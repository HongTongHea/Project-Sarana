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
        } elseif ($user->role === 'manager') {
            return redirect()->route('manager.dashboard');
        } elseif ($user->role === 'cashier') {
            return redirect()->route('cashier.dashboard');
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

        // Decide user role based on email domain or other logic
        $role = $this->determineUserRole($googleUser->getEmail());

        // Create or update user
        $user = User::updateOrCreate(
            ['google_id' => $googleUser->getId()],
            [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => Hash::make(Str::random(16)), // random password, since OAuth
                'role' => $role,
                'email_verified_at' => now(),
                'picture_url' => $googleUser->getAvatar(), // Optional: save Google profile picture
            ]
        );

        // **FIX: Log user in using the role-specific guard**
        $guard = $this->getGuardForRole($user->role);
        Auth::guard($guard)->login($user, true);

        // Also regenerate session for security
        request()->session()->regenerate();

        // Redirect based on role
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

    /**
     * Get the guard name based on user role
     */
    private function getGuardForRole(string $role): string
    {
        switch ($role) {
            case 'admin':
                return 'admin';
            case 'manager':
                return 'manager';
            case 'cashier':
                return 'cashier';
            case 'customer':
                return 'customer';
            default:
                return 'web'; // fallback
        }
    }
}
