<?php

namespace App\Services;

use App\Models\User;
use App\Models\Conversation;
use App\Models\ConversationUser;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewConversationNotification;
use Illuminate\Support\Collection;

class ConversationService
{
    // public function startConversation(Request $request, User $creator): Conversation
    // {
    //     $attributes = $request->validated();

    //     return DB::transaction(function () use ($attributes, $creator) {
    //         $isGroup = ($attributes['type'] ?? 'private') === 'group'
    //             || count($attributes['participant_ids']) > 1;

    //         $conversation = Conversation::create([
    //             'name' => $isGroup ? ($attributes['name'] ?? 'New Group') : null,
    //             'created_by' => $creator->id,
    //             'description' => $attributes['description'] ?? null,
    //             'avatar' => $attributes['avatar'] ?? null,
    //             'type' => $isGroup ? 'group' : 'private',
    //         ]);

    //         $userIds = array_unique(array_merge($attributes['participant_ids'], [$creator->id]));

    //         foreach ($userIds as $userId) {
    //             ConversationUser::create([
    //                 'conversation_id' => $conversation->id,
    //                 'user_id' => $userId,
    //                 'role' => ($isGroup && $userId === $creator->id) ? 'admin' : 'member',
    //                 'joined_at' => now(),
    //             ]);
    //         }

    //         // Notify participants except creator
    //         $recipients = User::whereIn('id', $attributes['participant_ids'])
    //             ->where('id', '!=', $creator->id)
    //             ->get();

    //         Notification::send($recipients, new NewConversationNotification($conversation, $creator));

    //         return $conversation->load(['users', 'creator']);
    //     });
    // }

    public function startConversation(Request $request, User $creator): Conversation
    {
        $attributes = $request->validated();
        $participantIds = $attributes['participant_ids'];
        $type = $attributes['type'] ?? 'private';

        return DB::transaction(function () use ($attributes, $creator, $participantIds, $type) {

            // -------------------------------------------------------
            // 1. CHECK FOR EXISTING PRIVATE CONVERSATION
            // -------------------------------------------------------
            if ($type === 'private' && count($participantIds) === 1) {

                $otherUserId = $participantIds[0];

                // Find private conversation with BOTH users
                $existingConversation = Conversation::where('type', 'private')
                    ->whereHas('users', fn($q) => $q->where('user_id', $creator->id))
                    ->whereHas('users', fn($q) => $q->where('user_id', $otherUserId))
                    ->first();

                if ($existingConversation) {
                    return $existingConversation->load(['users', 'creator']);
                }
            }

            // Detect group mode
            $isGroup = $type === 'group' || count($participantIds) > 1;

            // -------------------------------------------------------
            // 2. CREATE NEW CONVERSATION
            // -------------------------------------------------------
            $conversation = Conversation::create([
                'name'        => $isGroup ? ($attributes['name'] ?? 'New Group') : null,
                'created_by'  => $creator->id,
                'description' => $attributes['description'] ?? null,
                'avatar'      => $attributes['avatar'] ?? null,
                'type'        => $isGroup ? 'group' : 'private',
            ]);

            // Attach users
            $userIds = array_unique(array_merge($participantIds, [$creator->id]));

            foreach ($userIds as $userId) {
                ConversationUser::create([
                    'conversation_id' => $conversation->id,
                    'user_id'         => $userId,
                    'role'            => ($isGroup && $userId === $creator->id) ? 'admin' : 'member',
                    'joined_at'       => now(),
                ]);
            }

            // Notify participants except creator  
            $recipients = User::whereIn('id', $participantIds)
                ->where('id', '!=', $creator->id)
                ->get();

            Notification::send($recipients, new NewConversationNotification($conversation, $creator));

            return $conversation->load(['users', 'creator']);
        });
    }


    public function getConversationsByUser(int $userId): Collection
    {
        return Conversation::with(['users', 'lastMessage'])
            ->where('created_by', $userId)
            ->whereHas('users', fn($q) => $q->where('user_id', $userId))
            ->orderByDesc('last_message_at')
            ->get();
    }

    /**
     * Fetch all conversations a user created or belongs to.
     */
    public function getUserConversations(int $userId, bool $includeArchived = false): Collection
    {
        $query = Conversation::with([
            'users',
            'lastMessage',
            'creator',
        ])
            ->where(function ($q) use ($userId) {
                $q->where('created_by', $userId)
                    ->orWhereHas('users', fn($uq) => $uq->where('user_id', $userId));
            });

        if (! $includeArchived) {
            $query->whereDoesntHave('users', function ($q) use ($userId) {
                $q->where('user_id', $userId)->wherePivot('is_archived', true);
            });
        }

        $conversations = $query->orderByDesc('last_message_at')->get();

        // Attach unread message counts
        $conversations->each(function ($conversation) use ($userId) {
            $conversation->unread_count = DB::table('message_users')
                ->join('messages', 'messages.id', '=', 'message_users.message_id')
                ->where('messages.conversation_id', $conversation->id)
                ->where('message_users.user_id', $userId)
                ->whereNull('message_users.read_at')
                ->count();
        });

        return $conversations;
    }


    public function getConversationDetails(int $conversationId): Conversation
    {
        $conversations = Conversation::with([
            'users',
            'creator',
            'messages' => fn($q) => $q->with(['sender', 'status'])->orderBy('created_at'),
        ])->findOrFail($conversationId);


        return $conversations;
    }


    public function updateConversation(int $conversationId, array $data): Conversation
    {
        $conversation = Conversation::findOrFail($conversationId);

        $conversation->update($data);

        return $conversation->load(['users', 'creator']);
    }

    public function deleteConversation(int $conversationId, int $userId): void
    {
        $conversation = Conversation::with('users')->findOrFail($conversationId);

        // Authorization: only creator or admin can delete
        $isAuthorized = $conversation->created_by === $userId ||
            $conversation->users()
            ->wherePivot('user_id', $userId)
            ->wherePivot('role', 'admin')
            ->exists();

        if (! $isAuthorized) {
            abort(403, 'You are not authorized to delete this conversation.');
        }

        DB::transaction(function () use ($conversation) {
            // Option 1: If Conversation model uses SoftDeletes
            $conversation->delete();

            // Option 2: If you want to permanently delete (cleanup)
            // MessageUser::whereIn('message_id', $conversation->messages()->pluck('id'))->delete();
            // $conversation->messages()->delete();
            // $conversation->users()->detach();
            // $conversation->forceDelete();

            // Broadcast event for real-time sync
            broadcast(new \App\Events\ConversationDeleted($conversation->id))->toOthers();
        });
    }
}
