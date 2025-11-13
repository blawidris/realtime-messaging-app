<?php

use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::post("auth/login", [LoginController::class, 'login'])->name('auth.login');
Route::post("auth/register", [RegisterController::class, 'register'])->name('auth.register');
Route::get("auth/verify-email/{id}", [RegisterController::class, 'verifyEmail'])->name('auth.register.verify-email');
Route::post("auth/logout", [LoginController::class, 'logout'])->middleware('auth:sanctum')->name('auth.logout');

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
