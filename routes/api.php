<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\{
    ProjectController,
    TaskController,
    CommentController,
    AttachmentController,
    ActivityLogController,
    NotificationController,
    ConversationController,
    MessageController,
    
};

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::post("auth/login", [LoginController::class, 'login'])->name('auth.login');
Route::post("auth/register", [RegisterController::class, 'register'])->name('auth.register');
Route::get("auth/verify-email/{id}", [RegisterController::class, 'verifyEmail'])->name('auth.register.verify-email');
Route::post("auth/logout", [LoginController::class, 'logout'])->middleware('auth:sanctum')->name('auth.logout');
Route::get('auth/me', function (Request $request) {
    $user = $request->user();

    return response()->json($user, 200);
})->middleware('auth:sanctum');

Route::group(['prefix' => 'conversations', "middleware" => 'auth:sanctum'], function () {
    Route::get("", [ConversationController::class, 'index'])->name('conversations.index');
    Route::post("start", [ConversationController::class, 'start'])->name('conversations.start');
    Route::get("{conversation_id}", [ConversationController::class, 'show'])->name('conversations.show');
    Route::match(['put', 'patch'], "{conversation_id}", [ConversationController::class, 'update'])->name('conversations.update');
    Route::delete("{conversation_id}", [ConversationController::class, 'destroy'])->name('conversations.destroy');

    // messages routes
    Route::get("{conversation_id}/messages", [MessageController::class, 'index'])->name('conversations.messages.index');
    Route::post("{conversation_id}/messages", [MessageController::class, 'send'])->name('conversations.messages.send');
    Route::post("{conversation_id}/messages/read", [MessageController::class, 'markAsRead'])->name('conversations.messages.read');
});


Route::get("users", [UserController::class, 'index'])->middleware('auth:sanctum')->name("users");


Route::middleware(['auth:sanctum'])->group(function () {
    
    // Projects
    Route::apiResource('projects', ProjectController::class);
    Route::get('projects/{project}/stats', [ProjectController::class, 'stats']);
    Route::post('projects/{project}/members', [ProjectController::class, 'addMember']);
    Route::delete('projects/{project}/members', [ProjectController::class, 'removeMember']);
    
    // Tasks
    Route::apiResource('tasks', TaskController::class);
    Route::post('tasks/{task}/assign', [TaskController::class, 'assign']);
    Route::post('tasks/{task}/unassign', [TaskController::class, 'unassign']);
    Route::post('tasks/{task}/status', [TaskController::class, 'changeStatus']);
    Route::post('tasks/{task}/priority', [TaskController::class, 'changePriority']);
    Route::post('projects/{project}/tasks/reorder', [TaskController::class, 'reorder']);
    
    // Comments
    Route::post('tasks/{task}/comments', [CommentController::class, 'store']);
    Route::post('projects/{project}/comments', [CommentController::class, 'store']);
    Route::put('comments/{comment}', [CommentController::class, 'update']);
    Route::delete('comments/{comment}', [CommentController::class, 'destroy']);
    
    // Attachments
    Route::post('tasks/{task}/attachments', [AttachmentController::class, 'store']);
    Route::post('projects/{project}/attachments', [AttachmentController::class, 'store']);
    Route::get('attachments/{attachment}/download', [AttachmentController::class, 'download'])
        ->name('attachments.download');
    Route::delete('attachments/{attachment}', [AttachmentController::class, 'destroy']);
    
    // Activity Logs
    Route::get('activity-logs', [ActivityLogController::class, 'index']);
    Route::get('projects/{project}/activity', [ActivityLogController::class, 'project']);
    Route::get('tasks/{task}/activity', [ActivityLogController::class, 'task']);
    
    // Notifications
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);
    Route::delete('notifications/{id}', [NotificationController::class, 'destroy']);
});