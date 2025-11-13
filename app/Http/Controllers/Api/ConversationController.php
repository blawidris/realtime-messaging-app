<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StartConversationRequest;
use App\Services\ConversationService;
use App\Traits\Helper;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    use Helper;

    public function __construct(protected ConversationService $service) {}

    public function index(Request $request)
    {
        $user = $request->user();

        $conversations = $this->service->getUserConversations($user->id);

        return $this->responseJson(true,  $conversations, 'Conversations retrieved successfully');
    }

    public function start(StartConversationRequest $request)
    {
        $user = $request->user();

        $conversation = $this->service->startConversation($request, $user);

        return $this->responseJson(true, $conversation, 'Conversation created successfully', 201);
    }


    public function show(Request $request, int $conversation_id)
    {
        $user = $request->user();

        $conversation = $this->service->getConversationDetails($conversation_id);

        return $this->responseJson(true, $conversation, 'Conversation details retrieved successfully');
    }

    public function update(StartConversationRequest $request, int $conversation_id)
    {
        // Update conversation details logic here
        $updatedConversation = $this->service->updateConversation($conversation_id, $request->validated());

        return $this->responseJson(true, $updatedConversation, 'Conversation updated successfully');
    }

    public function destroy(Request $request, int $conversation_id)
    {
        $user = $request->user();

        $this->service->deleteConversation($conversation_id, $user->id);

        return $this->responseJson(true, null, 'Conversation deleted successfully');
    }
}
