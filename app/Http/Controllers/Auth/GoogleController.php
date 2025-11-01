<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            // Cek apakah ada error dari Google
            if ($request->has('error')) {
                Log::error('Google Auth Error (from request): ' . $request->error);
                return redirect('/')->with('error', 'Login dengan Google dibatalkan: ' . $request->error);
            }
            
            // Dapatkan data user dari Google dengan timeout yang lebih tinggi
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->user();
            
            // Log informasi berhasil mendapatkan data dari Google
            Log::info('Google Auth: Berhasil mendapatkan data user dari Google', ['email' => $googleUser->email]);
            
            $user = User::where('email', $googleUser->email)->first();
            
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(rand(100000, 999999)),
                    'role' => 'user',
                ]);
                Log::info('Google Auth: User baru dibuat', ['email' => $user->email]);
            }
            
            // Login user
            Auth::login($user);
            
            // Buat token untuk API
            $token = $user->createToken('auth_token')->plainTextToken;
            
            // Redirect ke halaman sukses login dengan token
            return redirect()->route('login.success')->with('token', $token)->with('user', $user);
            
        } catch (\Exception $e) {
            // Log error untuk debugging dengan detail lebih lengkap
            Log::error('Google Auth Error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            // Redirect ke halaman utama dengan pesan error
            return redirect('/')->with('error', 'Login dengan Google gagal. Silakan coba lagi atau hubungi administrator. Detail: ' . $e->getMessage());
        }
    }
}
