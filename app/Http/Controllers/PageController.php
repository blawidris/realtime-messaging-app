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

    public function talentOnboarding(Request $request)
    {
        return view('onboarding.talents.setup');
    }

    public function paymentBills(Request $request)
    {

        $payments = [
            [
                'id' => 1,
                'avatar' => 'https://i.pravatar.cc/100?img=1',
                'name' => 'Fatima El-S',
                'role' => 'Customer Support',
                'project' => 'Support',
                'amount' => '£5,000',
                'currency' => 'Euros',
                'scheduled_date' => '24/01/2025',
                'payment_method' => 'Default card',
                'status' => 'deferred',
            ],
            [
                'id' => 2,
                'avatar' => 'https://i.pravatar.cc/100?img=2',
                'name' => 'Leila C',
                'role' => 'Business Analyst',
                'project' => 'Business Team',
                'amount' => '£5,000',
                'currency' => 'Euros',
                'scheduled_date' => '24/01/2025',
                'payment_method' => 'Default card',
                'status' => 'deferred',
            ],
            [
                'id' => 3,
                'avatar' => 'https://i.pravatar.cc/100?img=3',
                'name' => 'Aisha A',
                'role' => 'Finance Analyst',
                'project' => 'Fintech App',
                'amount' => '£5,000',
                'currency' => 'Euros',
                'scheduled_date' => '24/01/2025',
                'payment_method' => 'Default card',
                'status' => 'deferred',
            ],
            [
                'id' => 4,
                'avatar' => 'https://i.pravatar.cc/100?img=4',
                'name' => 'Brain O',
                'role' => 'Front-end Support',
                'project' => 'Landing Page',
                'amount' => '£5,000',
                'currency' => 'Euros',
                'scheduled_date' => '24/01/2025',
                'payment_method' => 'Default card',
                'status' => 'Deferred',
            ],
        ];

        $pastPayments = [
            [
                'id' => 1,
                'avatar' => 'https://i.pravatar.cc/100?img=5',
                'name' => 'Fatima El-S',
                'type' => 'Salary',
                'amount' => '£5,000',
                'payment_date' => '24/01/2025',
                'payment_method' => 'transfer',
                'status' => 'completed',
            ],
            [
                'id' => 2,
                'avatar' => 'https://i.pravatar.cc/100?img=6',
                'name' => 'Leila C',
                'type' => 'Contract',
                'amount' => '£3,200',
                'payment_date' => '24/01/2025',
                'payment_method' => 'card',
                'status' => 'completed',
            ],
            [
                'id' => 3,
                'avatar' => 'https://i.pravatar.cc/100?img=7',
                'name' => 'Aisha A',
                'type' => 'Bonus',
                'amount' => '£1,500',
                'payment_date' => '24/01/2025',
                'payment_method' => 'transfer',
                'status' => 'failed',
            ],
        ];

        $cards = [
            [
                'id' => 1,
                'name' => 'Monobank Card',
                'last4' => '1231',
                'brand' => 'visa',
                'expiry' => 'March, 2025',
                'is_default' => true,
            ],
            [
                'id' => 2,
                'name' => 'Subscription Card',
                'last4' => '2436',
                'brand' => 'mastercard',
                'expiry' => 'March, 2025',
                'is_default' => false,
            ],
            [
                'id' => 3,
                'name' => 'Verve Card',
                'last4' => '1231',
                'brand' => 'visa',
                'expiry' => 'March, 2025',
                'is_default' => false,
            ],
        ];


        return view('payment.index', [
            "pageTitle" => "Payments and Billings",
            "payments" =>  $payments,
            "pastPayments" => $pastPayments,
            "cards" => $cards,
        ]);
    }

    public function paymentTopup(Request $request)
    {
        $amout = $request->query("amount") ?? 0;
        $charges = $amout * 0.02;
        $total = $amout + $charges;

        return view('payment.topup', [
            "pageTitle" => "Top up - Payment",
            'total' => $total,
            'charges' => $charges,
            'amount' => $amout,
        ]);
    }

    public function formStep($step, Request $request)
    {
        $data = $request->all();

        return response()->json([
            'status' => 'success',
            'message' => "Step {$step} data saved successfully.",
            'data' => $data,
            'step' => $step + 1,
        ]);
    }
}
