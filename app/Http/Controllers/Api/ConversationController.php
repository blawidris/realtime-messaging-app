<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StartConversationRequest;
use App\Services\Chat\ConversationService;
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

        return $this->responseJson(true, 'Conversations retrieved successfully', $conversations);
    }

    public function createConverstation(StartConversationRequest $request)
    {
        $user = $request->user();

        $conversation = $this->service->startConversation($request, $user);

        return $this->responseJson(true, 'Conversation created successfully', $conversation);
    }
}
