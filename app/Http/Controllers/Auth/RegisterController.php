<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\Auth\RegisterService;
use App\Traits\Helper;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use Helper;

    public function __construct(protected RegisterService $service) {}

    public function register(RegisterRequest $request)
    {
        $createdUser = $this->service->register($request->validated());

        return $this->responseJson(true, 'User registered successfully. Please check your email to verify your account.', [
            'user' => $createdUser,
        ], 201);
    }

    public function verifyEmail($id, Request $request)
    {
        
        $isVerify = $this->service->verifyEmail($id, $request);

        if (!$isVerify) {
            return $this->responseJson(false, 'Invalid or expired verification link.', [], 400);
        }

        return $this->responseJson(true, 'Email verified successfully.', [], 200);
    }
}
