<?php

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

Route::group(['prefix' => 'auth', "middleware" => 'auth:sanctum'], function () {
    Route::get("logout", [LoginController::class, 'logout']);
});
