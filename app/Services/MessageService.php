<?php

namespace App\Services;

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
}
