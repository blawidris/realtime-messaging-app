<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\TalentController;
use App\Http\Controllers\ClientController;


Route::get('/', [PageController::class, 'signin']);
Route::get('/signup', [PageController::class, 'signup']);
Route::get('/forgot-password', [PageController::class, 'forgotPassword']);
Route::get('/verify-email', [PageController::class, 'verifyEmail']);
Route::get('/reset-password', [PageController::class, 'resetPassword']);

Route::get("/client/setup", [PageController::class, "setupClient"]);