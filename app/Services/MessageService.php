<?php

namespace App\Services;

use App\Events\MessageRead;
use App\Models\Message;
use App\Models\Conversation;

use App\Events\MessageSent;
use App\Models\Status;
use Illuminate\Support\Facades\DB;

class MessageService
{
    public function __construct(protected Message $model) {}

    public function getConversationMessages($request, int|string $conversationId)
    {
        $perPage = $request->input('per_page', 20);

        $conversation = Conversation::findOrFail($conversationId);

        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return $messages;
    }

    public function sendMessage(int|string $conversationId, array $data)
    {
        $conversation = Conversation::findOrFail($conversationId);

        return DB::transaction(function () use ($conversation, $data) {

            $message = $conversation->messages()->create($data);

            $message->status()->create([
                "user_id" => $data['user_id'],
                "status_id" => Status::getId('sent')
            ]);

            // broadcast new message event here if needed
            broadcast(new MessageSent($message))->toOthers();


            return $message->load(['sender', "status"]);
        });
    }

    public function markMessagesAsRead(int|string $conversationId, int|string $userId)
    {
        $conversation = Conversation::with(['messages' => fn($q) => $q->orderBy('created_at')])
            ->findOrFail($conversationId);

        $user = $conversation->users()->where('user_id', $userId)->firstOrFail();

        // Get all unread messages for this user
        $unreadMessageIds = $conversation->messages()
            ->whereHas('messageUsers', fn($q) => $q->where('user_id', $userId)->whereNull('read_at'))
            ->pluck('id');

        $lastUnreadId = $unreadMessageIds->last() ?? null;

        if ($unreadMessageIds->isNotEmpty()) {
            // Mark messages as read in message_users table
            DB::table('message_users')
                ->whereIn('message_id', $unreadMessageIds)
                ->where('user_id', $userId)
                ->update(['read_at' => now(), 'status_id' => Status::getId('read')]);

            // Update conversation_user pivot with last read info
            $conversation->users()->updateExistingPivot($userId, [
                'last_read_at' => now(),
                'last_read_message_id' => $lastUnreadId,
            ]);

            // Broadcast event to other participants
            broadcast(new MessageRead(
                $conversation->id,
                $lastUnreadId,
                $user
            ))->toOthers();
        }

        return $lastUnreadId; // Optionally return the last read message ID
    }
}
