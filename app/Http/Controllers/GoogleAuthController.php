<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GoogleAuthController extends Controller
{
    /**
     * Redirect users after login based on role.
     */
    private function redirectBasedOnRole($user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'customer') {
            return redirect()->route('homepage.index');
        }

        abort(403, 'Unauthorized role.');
    }

    /**
     * Redirect to Google OAuth.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback.
     */
  public function callback()
{
    $googleUser = Socialite::driver('google')->user();

    $role = $this->determineUserRole($googleUser->getEmail());

    $user = User::updateOrCreate(
        ['google_id' => $googleUser->getId()],
        [
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'password' => Hash::make(Str::random(16)),
            'role' => $role,
            'email_verified_at' => now(),
        ]
    );

    Auth::login($user, true);

    // Check if user was trying to checkout
    if (session()->has('intended_checkout') && in_array($user->role, ['customer', 'admin'])) {
        session()->forget('intended_checkout');
        return redirect()->route('checkout');
    }

    return $this->redirectBasedOnRole($user);
}

    /**
     * Determine user role based on email or other logic.
     * You can customize this for your needs.
     */
    private function determineUserRole(string $email): string
    {
        // Example: emails ending with @yourcompany.com are admins
        if (str_ends_with($email, '@yourcompany.com')) {
            return 'admin';
        }
        // Default role
        return 'customer';
    }
}
