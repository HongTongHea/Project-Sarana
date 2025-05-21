<?php

namespace App\Http\Controllers;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback() {

        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            [
                'google_id' => $googleUser->getId(),
            ],
            [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => Str::password(12), // Generate a random password
                'role' => 'customer', 
                'email_verified_at' => now(), // Set the default role
            ]
        );

        Auth::login($user, true);

        return redirect()->route('dashboard');

    }
        
}
