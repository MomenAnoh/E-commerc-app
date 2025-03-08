<?php

namespace App\Services\Front;

use App\Models\Otp;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class AuthService
{
    /**
     * Register a new user.
     *
     * @param array $data
     * @return User
     */


    public function register(array $data): User
    {
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
        ]);

        // إنشاء كود التحقق OTP
        $code = rand(100000, 999999);
        Otp::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(2),
        ]);

        // إرسال كود التحقق بالبريد الإلكتروني
        Mail::raw("Validation Code is: " . $code, function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Validation Code');
        });

        return $user;
    }
    public function login(array $credentials)
    {
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Data',
            ], 401);
        }

        $user = Auth::user();
          if ($user) {
            $create_token = $user->createToken('my token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'User login successfully',
                'user' => $user,
                'authorisation' => [
                    'token' => $create_token,
                    'type' => 'bearer',
                ],
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 500);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });
        return response()->noContent();
    }




}
