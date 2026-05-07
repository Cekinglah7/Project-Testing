<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NomerAuthController extends Controller
{
    public function sendOTP (Request $request)
    {
        $request->validate([
            'telepon' => 'required|numeric|digits_between:10,15'
        ]);

        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $key = 'otp_' . $request->no_hp; 
        Cache::put($key, $otp, now()->addMinutes(5));

        log::info("OTP untuk nomor {$request->no_hp} ini: {$otp}");

        return back()->with('success', 'OTP telah dikirim ke nomor telepon Anda.');
    }

    public function verifyOTP (Request $request)
    {
        $request->validate([
            'telepon' => 'required|numeric|digits_between:10,15',
            'otp' => 'required|digits:6'
        ]);

        $key = 'otp_' . $request->telepon;
        $cachedOtp = Cache::get($key);

        if ($cachedOtp && $cachedOtp === $request->otp) {
            Cache::forget($key);
            return back()->with('success', 'OTP berhasil diverifikasi. Anda sekarang dapat masuk.');
        } else {
            return back()->with('error', 'OTP tidak valid atau sudah kedaluwarsa.');
        }
    }
}
