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
    public function startConversation(Request $request, User $creator): Conversation
    {
        $attributes = $request->validated();

        return DB::transaction(function () use ($attributes, $creator) {
            $isGroup = ($attributes['type'] ?? 'private') === 'group'
                || count($attributes['participant_ids']) > 1;

            $conversation = Conversation::create([
                'name' => $isGroup ? ($attributes['name'] ?? 'New Group') : null,
                'created_by' => $creator->id,
                'description' => $attributes['description'] ?? null,
                'avatar' => $attributes['avatar'] ?? null,
                'type' => $isGroup ? 'group' : 'private',
            ]);

            $userIds = array_unique(array_merge($attributes['participant_ids'], [$creator->id]));

            foreach ($userIds as $userId) {
                ConversationUser::create([
                    'conversation_id' => $conversation->id,
                    'user_id' => $userId,
                    'role' => ($isGroup && $userId === $creator->id) ? 'admin' : 'member',
                    'joined_at' => now(),
                ]);
            }

            // Notify participants except creator
            $recipients = User::whereIn('id', $attributes['participant_ids'])
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
}
