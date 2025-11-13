<?php

namespace App\Services\Auth;

use App\Models\Status;
use App\Models\User;
use App\Notifications\SendVerificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

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

    public function verifyEmail(string|int $userId, Request $request): bool
    {
        $hash = $request->query('signature');
        $expire = $request->query('expires');
        $user = User::find($userId);


        if (!$user) {
            throw new \Exception("User not found.");
        }

        logger()->info("Verifying email for user ID: {$userId} with hash: {$hash} and expire time: {$expire}");

        // Fix expiration check
        if (now()->timestamp > $expire) {
            return false; // URL expired
        }

        // if (! URL::hasValidSignature($request)) {
        //     return false; // Invalid or expired link
        // }

        // if (!hash_equals($hash ?? '', sha1($user->getEmailForVerification()))) {
        //     return false;
        // }

        return $user->update([
            'status_id' => Status::getId('active'),
            'email_verified_at' => now(),
        ]);
    }
}
