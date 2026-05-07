<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    // --- GOOGLE ---
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        $this->registerOrLoginUser($googleUser, 'google');
        return redirect('/dashboard');
    }

    // --- FACEBOOK ---
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->user();
        $this->registerOrLoginUser($facebookUser, 'facebook');
        return redirect('/dashboard');
    }

    // --- FUNGSI BANTUAN ---
    protected function registerOrLoginUser($socialUser, $provider)
    {
        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'password' => bcrypt(str::random(16)),
            ]);
        }

        Auth::login($user);
    }

    public function loginGoogleApi(Request $request)
    {
        try {
            $googleToken = $request->token;

            $googleUser = Socialite::driver('google')->stateless()->userFromToken($googleToken);

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => bcrypt(Str::random(16)),
                ]
            );

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login sukses',
                'access_token' => $token,
                'user' => $user
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal verifikasi token',
                'detail_error' => $e->getMessage() 
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Berhasil logout, token telah dihapus.'
        ]);
    }
}
