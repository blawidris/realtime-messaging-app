<?php

class ConversationService
{
    public function startConversation(array $participants): int
    {
        // Implement conversation starting logic here
        return 1; // Return conversation ID
    }
    
    public function sendMessage(int $conversationId, int $senderId, string $message): bool
    {
        // Implement message sending logic here
        return true;
    }

    public function getMessages(int $conversationId): array
    {
        // Implement message retrieval logic here
        return []; // Return array of messages
    }
}
