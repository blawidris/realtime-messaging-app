<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function signin(Request $request)
    {
        return view("auths.login", ['title' => "Login"]);
    }

    public function signup(Request $request)
    {
        return view("onboarding.index", ['title' => "Create Account"]);
    }

    public function forgotPassword()
    {
        return view("auths.forgot-password",  ['title' => "Forgot Password"]);
    }

    public function verifyEmail()
    {
        return view("auths.verify-email",  ['title' => "Verify Email"]);
    }

    public function resetPassword()
    {
        return view("auths.reset-password",  ['title' => "Reset Password"]);
    }

    public function setupClient()
    {
        return view("onboarding.client.setup-form",  ['title' => "Create Account - Choose Account Type"]);
    }

    public function successful()
    {
        return view("success");
    }
}
