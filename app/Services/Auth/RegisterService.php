<?php

namespace App\Services\Auth;

use App\Models\Status;
use App\Models\User;
use App\Notifications\SendVerificationEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    public function register(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $data['status_id'] = Status::getId('pending');
            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            // Send verification email (queued)
            $user->notify(new SendVerificationEmail($user));

            return $user;
        });
    }

    public function verifyEmail(User $user): bool
    {
        return $user->update([
            'status_id' => Status::getId('active'),
            'email_verified_at' => now(),
        ]);
    }
}
