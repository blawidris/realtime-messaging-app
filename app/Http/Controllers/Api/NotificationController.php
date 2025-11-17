<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Get all notifications for authenticated user
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        
        $notifications = $request->user()
            ->notifications()
            ->when($request->unread_only, fn($q) => $q->whereNull('read_at'))
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return NotificationResource::collection($notifications);
    }

    /**
     * Get unread notifications count
     */
    public function unreadCount(Request $request): JsonResponse
    {
        $count = $request->user()->unreadNotifications()->count();

        return response()->json([
            'count' => $count,
        ]);
    }

    /**
     * Get unread notifications
     */
    public function unread(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        
        $notifications = $request->user()
            ->unreadNotifications()
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return NotificationResource::collection($notifications);
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead(string $id, Request $request): JsonResponse
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        return response()->json([
            'message' => 'Notification marked as read',
            'data' => new NotificationResource($notification->fresh()),
        ]);
    }

    /**
     * Mark multiple notifications as read
     */
    public function markMultipleAsRead(Request $request): JsonResponse
    {
        $request->validate([
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'string',
        ]);

        $count = $request->user()
            ->unreadNotifications()
            ->whereIn('id', $request->notification_ids)
            ->update(['read_at' => now()]);

        return response()->json([
            'message' => "{$count} notifications marked as read",
            'count' => $count,
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        $count = $request->user()
            ->unreadNotifications()
            ->count();

        $request->user()->unreadNotifications->markAsRead();

        return response()->json([
            'message' => 'All notifications marked as read',
            'count' => $count,
        ]);
    }

    /**
     * Mark a notification as unread
     */
    public function markAsUnread(string $id, Request $request): JsonResponse
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notification->update(['read_at' => null]);

        return response()->json([
            'message' => 'Notification marked as unread',
            'data' => new NotificationResource($notification->fresh()),
        ]);
    }

    /**
     * Delete a notification
     */
    public function destroy(string $id, Request $request): JsonResponse
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notification->delete();

        return response()->json([
            'message' => 'Notification deleted successfully',
        ]);
    }

    /**
     * Delete multiple notifications
     */
    public function destroyMultiple(Request $request): JsonResponse
    {
        $request->validate([
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'string',
        ]);

        $count = $request->user()
            ->notifications()
            ->whereIn('id', $request->notification_ids)
            ->delete();

        return response()->json([
            'message' => "{$count} notifications deleted successfully",
            'count' => $count,
        ]);
    }

    /**
     * Delete all read notifications
     */
    public function deleteAllRead(Request $request): JsonResponse
    {
        $count = $request->user()
            ->notifications()
            ->whereNotNull('read_at')
            ->delete();

        return response()->json([
            'message' => "{$count} read notifications deleted",
            'count' => $count,
        ]);
    }

    /**
     * Get notification by ID
     */
    public function show(string $id, Request $request)
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        // Mark as read when viewed
        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        return new NotificationResource($notification);
    }

    /**
     * Get notification preferences
     */
    // public function preferences(Request $request): JsonResponse
    // {
    //     $preferences = $request->user()->notification_preferences ?? [
    //         'email' => [
    //             'task_assigned' => true,
    //             'task_due_soon' => true,
    //             'task_overdue' => true,
    //             'task_completed' => false,
    //             'comment_mention' => true,
    //             'project_invitation' => true,
    //         ],
    //         'push' => [
    //             'task_assigned' => true,
    //             'task_due_soon' => false,
    //             'comment_mention' => true,
    //         ],
    //     ];

    //     return response()->json([
    //         'data' => $preferences,
    //     ]);
    // }

    /**
     * Update notification preferences
     */
    // public function updatePreferences(Request $request): JsonResponse
    // {
    //     $request->validate([
    //         'email' => 'sometimes|array',
    //         'push' => 'sometimes|array',
    //         'database' => 'sometimes|array',
    //     ]);

    //     $user =$request->user();
    //     $user->notification_preferences = $request->all();
    //     $user->save();

    //     return response()->json([
    //         'message' => 'Notification preferences updated',
    //         'data' => $user->notification_preferences,
    //     ]);
    // }
}