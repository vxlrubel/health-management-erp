<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConversationCollection;
use App\Http\Resources\MessageCollection;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct(
        protected MessageService $messageService
    ) {}

    /**
     * List conversations
     */
    public function conversations(Request $request): JsonResponse
    {
        $options = [
            'per_page' => $request->input('per_page', 15),
        ];

        $conversations = $this->messageService->conversations($options);

        return $this->paginatedResponse(
            new ConversationCollection($conversations)
        );
    }

    /**
     * Show conversation messages
     */
    public function show(Conversation $conversation, Request $request): JsonResponse
    {
        $options = [
            'per_page' => $request->input('per_page', 15),
        ];

        $messages = $this->messageService->conversationMessages($conversation, $options);

        return $this->paginatedResponse(
            new MessageCollection($messages)
        );
    }

    /**
     * Send message
     */
    public function send(Conversation $conversation, Request $request): JsonResponse
    {
        $request->validate(['body' => ['required', 'string']]);

        $message = $this->messageService->send($conversation, $request->input('body'));

        return $this->createdResponse(
            new MessageResource($message),
            'Message sent successfully.'
        );
    }

    /**
     * Mark messages as read
     */
    public function markRead(Request $request): JsonResponse
    {
        $request->validate(['conversation_id' => ['required', 'exists:conversations,id']]);

        $conversation = Conversation::findOrFail($request->input('conversation_id'));

        $this->messageService->markAsRead($conversation);

        return $this->successResponse(null, 'Messages marked as read.');
    }
}
