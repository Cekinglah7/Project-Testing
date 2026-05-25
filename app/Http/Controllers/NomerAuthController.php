<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SendOtpRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Helpers\Notification;

class NomerAuthController extends Controller
{
    public function sendOTP(SendOtpRequest $request)
    {
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $key = 'otp_' . $request->telepon; 
        Cache::put($key, $otp, now()->addMinutes(5));

        Log::info("OTP untuk nomor {$request->telepon} ini: {$otp}");

        return Notification::success('OTP telah dikirim ke nomor telepon Anda.');
    }

    public function verifyOTP(VerifyOtpRequest $request)
    {
        $key = 'otp_' . $request->telepon;
        $cachedOtp = Cache::get($key);

        if ($cachedOtp && $cachedOtp === $request->otp) {
            Cache::forget($key); 

            $user = User::firstOrCreate(
            ['telepon' => $request->telepon],
            ['name' => 'User ' . substr($request->telepon, -4), 'password' => bcrypt(\Illuminate\Support\Str::random(16)),]
        );
            
            $token = $user->createToken('auth_token')->plainTextToken;
            $user->token = $token;

            return Notification::success('OTP berhasil diverifikasi.', new AuthResource($user));
        }

        return Notification::error('OTP tidak valid atau sudah kedaluwarsa.', null, 400);
    }
}
