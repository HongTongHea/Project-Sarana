<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class GoogleAuthController extends Controller
{
    private function redirectBasedOnRole($user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        } elseif ($user->role === 'customer') {
            return redirect()->route('homepage.index');
        }

        // default fallback
        abort(403, 'Unauthorized role.');
    }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {

        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            [
                'google_id' => $googleUser->getId(),
            ],
            [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => Hash::make($googleUser->password),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        );

        Auth::login($user, true);
        return $this->redirectBasedOnRole($user);
    }
}
