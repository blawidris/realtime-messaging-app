<?php


namespace App\Services\Auth;

use App\Models\User;
use App\Traits\Helper;
use Illuminate\Support\Facades\Hash;

class LoginService
{
    use Helper;

    public function login(array $credentials)
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return ["status" => false, "message" => 'User not found', "code" => 404];
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return ["status" => false, "message" => 'Invalid credentials', "code" => 401];
        }

        // Optionally, revoke old tokens to prevent token clutter
        $user->tokens()->delete();

        // Create a new token (you can also use device name or something descriptive)
        $token = $user->createToken('auth_token')->plainTextToken;

        $data = [
            'status' => true,
            'data ' => [
                'token' => $token,
                'user' => $user
            ],
            'message' => 'Login successful',
        ];

        $user->update(['is_online' => true, 'last_seen_at' => now()]);


        return $data;
    }



    public function logout(int $userId): bool
    {
        $user = User::find($userId);

        if (!$user) {
            return false;
        }

        // Revoke all tokens for the user
        $user->tokens()->delete();

        $user->update(['is_online' => false]);

        return true;
    }
}
