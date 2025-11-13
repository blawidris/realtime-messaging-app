<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttachementRequest;
use App\Http\Requests\NewMessageRequest;
use App\Services\MessageService;
use App\Traits\Helper;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    use Helper;

    public function __construct(protected MessageService $service) {}


    public function index(Request $request, int $conversation_id)
    {
        $response = $this->service->getConversationMessages($request, $conversation_id);

        $messages = $response->items();
        $pagination = [
            "current_page" => $response->currentPage(),
            "last_page" => $response->lastPage(),
            "per_page" => $response->perPage(),
            "total" => $response->total(),
        ];

        return $this->responseJson(true, [
            "messages" => $messages,
            "pagination" => $pagination
        ], 'Messages retrieved successfully');
    }

    public function send(NewMessageRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $message = $this->service->sendMessage($request->conversation_id, $data);

        return $this->responseJson(true, $message, 'Message sent successfully', 201);
    }

    public function uploadAttachment(AttachementRequest $request)
    {
        $request->validate([
            'attachment' => 'required|file|max:10240', // max 10MB
        ]);
    }
}
