<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Services\Front\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {
    }
    public function register(UserRegisterRequest $request)
    {
        $this->authService->register($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully. Please check your email for verification code.'
        ]);
    }
    public function login(UserLoginRequest  $request)
    {
        $data = $this->authService->login($request->validated());
        return $data;
    }
    public function logout(Request $request)
    {
        $data = $this->authService->logout($request);

        return response()->json(['status' => 'success', 'message' => 'User Logout successfully..']);
    }
    public function profile(Request $request)
    {
        $user = Auth::user();
        return response()->json(['status' => 'success', 'user' => $request->user(),], 200);
    }
}
