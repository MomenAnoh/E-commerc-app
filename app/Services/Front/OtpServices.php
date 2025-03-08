<?php

namespace App\Services\Front;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SendResetCodeRequest;
use App\Http\Requests\VerifyResetCodeRequest;
use App\Models\Otp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class OtpServices
{
    /**
     * إرسال كود إعادة تعيين كلمة المرور إلى البريد الإلكتروني.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetCode(SendResetCodeRequest $request)
    {



        // جلب بيانات المستخدم
        $user = User::where('email', $request->email)->firstOrFail();

        // توليد كود تحقق عشوائي مكون من 6 أرقام بشكل آمن
        $otp = random_int(100000, 999999);

        // حذف أي كود سابق لنفس المستخدم
        Otp::where('user_id', $user->id)->delete();

        // إنشاء كود جديد
        Otp::create([
            'user_id' => $user->id,
            'code' => $otp,
            'expire_at' => Carbon::now()->addMinutes(10), // الكود صالح لمدة 10 دقائق
        ]);


            Mail::raw("Your password reset code is: $otp", function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Password Reset Code');
            });

            return response()->json(['message' => 'Reset code sent to your email.']);

    }
    public function verifyResetCode(VerifyResetCodeRequest $request)
    {

        $otpRecord = Otp::where('code', $request->otp)
            ->where('expire_at', '>', now())
            ->first();

        if (!$otpRecord) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or expired OTP.',
            ], 400);
        }

        $user = User::find($otpRecord->user_id);

        return response()->json([
            'status' => 'success',
            'message' => 'OTP verified successfully. You can now reset your password.',
        ]);
    }
    public function resetPassword(ResetPasswordRequest $request)
    {


        $user = User::where('email', $request->email)->first();

        // تحديث كلمة المرور
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // حذف جميع أكواد OTP الخاصة بالمستخدم بعد تغيير كلمة المرور
        Otp::where('user_id', $user->id)->delete();
        Mail::raw("Your password Changed Successfuly", function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Password Reset Code');
        });
        return response()->json([
            'status' => 'success',
            'message' => 'Password reset successfully.',
        ]);
    }
    public function changePassword(ChangePasswordRequest $request)
    {
        // التحقق من المدخلات



        $user = User::where('email', $request->email)->first();

        // التحقق من صحة كلمة المرور القديمة
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Old password is incorrect.',
            ], 400);
        }


        $user->update([
            'password' => Hash::make($request->new_password),
        ]);


        $user->tokens()->delete();
        Mail::raw("Your password has been changed successfully." , function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Password Changed');
        });

        $user->tokens()->delete();
         $newToken = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Password changed successfully.',
            'token' => $newToken,
        ]);
    }
}
