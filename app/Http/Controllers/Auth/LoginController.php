<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Auth\LoginService;
use App\Traits\Helper;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    use Helper;

    public function __construct(protected LoginService $service) {}

    public function login(LoginRequest $request)
    {
        $login = $this->service->login($request->validated());

        if ($login['status'] === false) {
            return $this->responseJson(false, message: $login['message'], statusCode: $login['code']);
        }

        return $this->responseJson(true, $login['data'], 'Login successful', 200);
    }

    public function logout(Request $request)
    {
        $logout = $this->service->logout($request->user()->id);

        return $this->responseJson($logout, message: $logout ? 'Logout successful' : 'Logout failed');
    }
}
