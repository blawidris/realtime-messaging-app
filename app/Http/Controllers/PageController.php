<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function signin(Request $request)
    {
        return view("auths.login");
    }

    public function signup(Request $request)
    {
        return view("onboarding.index");
    }

    public function forgotPassword()
    {
        return view("auths.forgot-password");
    }

    public function verifyEmail()
    {
        return view("auths.verify-email");
    }

    public function resetPassword()
    {
        return view("auths.reset-password");
    }
}
