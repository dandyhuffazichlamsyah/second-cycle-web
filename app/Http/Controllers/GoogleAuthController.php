<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirect()
    {
        return Socialite::driver('google')
            ->redirect();
    }

    /**
     * Handle the callback from Google OAuth.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Find or create user
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if ($user) {
                // Update existing user with Google ID if missing
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
            } else {
                // Create new user from Google data
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => null, // No password for OAuth users
                    'role' => 'customer', // Default role for Google users
                    'email_verified_at' => now(),
                ]);
            }

            // Login the user
            Auth::login($user, true);

            // Redirect based on user role
            if ($user->hasAdminAccess()) {
                $roleLabel = $user->getRoleLabel();
                return redirect()->route('admin.dashboard')
                    ->with('success', "Selamat datang kembali, {$roleLabel}!");
            } else {
                return redirect()->route('dashboard')
                    ->with('success', 'Login berhasil! Selamat datang di SecondCycle.');
            }

        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            
            return redirect()->route('login')
                ->with('error', 'Login dengan Google gagal. Silakan coba lagi atau gunakan email/password.');
        }
    }

    /**
     * Logout the user and revoke Google access.
     */
    public function logout()
    {
        Auth::logout();
        
        return redirect()->route('home')
            ->with('success', 'Anda telah berhasil logout.');
    }
}
