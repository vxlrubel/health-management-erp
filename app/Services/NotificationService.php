<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public function list(array $options = []): LengthAwarePaginator
    {
        $perPage = $options['per_page'] ?? 15;

        return Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function unreadCount(): int
    {
        return Auth::user()->unreadNotifications()->count();
    }

    public function markAsRead(string $notificationId): void
    {
        $notification = Auth::user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();
    }

    public function markAllAsRead(): void
    {
        Auth::user()->unreadNotifications->markAsRead();
    }
}
