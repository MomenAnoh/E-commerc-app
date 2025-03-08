<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SendResetCodeRequest;
use App\Http\Requests\VerifyResetCodeRequest;
use App\Services\Front\OtpServices;
use Illuminate\Http\Request;


class PasswordController extends Controller
{
    protected $otpService;

    public function __construct()
    {
        $this->otpService = new OtpServices();
    }

    public function sendResetCode(SendResetCodeRequest $request)
    {
        return $this->otpService->sendResetCode($request);
    }
    public function verifyResetCode(VerifyResetCodeRequest $request)
    {
         return $this->otpService->verifyResetCode($request);
    }
    public function resetPassword(ResetPasswordRequest $request)
    {
        return $this->otpService->resetPassword($request);
    }
    // إعادة تعيين كلمة المرور
    public function changePassword(ChangePasswordRequest $request)
    {
        return $this->otpService->changePassword($request);
    }

}
