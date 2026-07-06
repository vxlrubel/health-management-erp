<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(
        protected NotificationService $notificationService
    ) {}

    /**
     * List notifications
     */
    public function index(Request $request): JsonResponse
    {
        $options = [
            'per_page' => $request->input('per_page', 15),
        ];

        $notifications = $this->notificationService->list($options);

        return $this->successResponse([
            'notifications' => $notifications->items(),
            'unread_count' => $this->notificationService->unreadCount(),
            'pagination' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'per_page' => $notifications->perPage(),
                'total' => $notifications->total(),
            ],
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markRead(Request $request): JsonResponse
    {
        $request->validate(['id' => ['required', 'string']]);

        $this->notificationService->markAsRead($request->input('id'));

        return $this->successResponse(null, 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read
     */
    public function markAllRead(): JsonResponse
    {
        $this->notificationService->markAllAsRead();

        return $this->successResponse(null, 'All notifications marked as read.');
    }
}
