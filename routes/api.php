<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post("login", [LoginController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get("logout", [LoginController::class, 'logout']);
    Route::post("register", [RegisterController::class, 'register']);
    Route::get("verify-email/{id}/{hash}", [RegisterController::class, 'verifyEmail'])
        ->name('verification.verify');
});
