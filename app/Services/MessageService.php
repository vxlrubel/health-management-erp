<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class MessageService
{
    public function conversations(array $options = []): LengthAwarePaginator
    {
        $perPage = $options['per_page'] ?? 15;

        return Conversation::query()
            ->withCount('messages')
            ->with('messages')
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage);
    }

    public function conversationMessages(Conversation $conversation, array $options = []): LengthAwarePaginator
    {
        $perPage = $options['per_page'] ?? 15;

        return $conversation->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->paginate($perPage);
    }

    public function send(Conversation $conversation, string $body): Message
    {
        return $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'body' => $body,
        ]);
    }

    public function markAsRead(Conversation $conversation): void
    {
        $conversation->messages()
            ->whereNull('read_at')
            ->where('sender_id', '!=', Auth::id())
            ->update(['read_at' => now()]);
    }

    public function createConversation(?string $subject = null): Conversation
    {
        return Conversation::create([
            'subject' => $subject,
        ]);
    }
}
