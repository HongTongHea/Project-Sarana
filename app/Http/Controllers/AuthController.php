<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Redirect user based on role
     */
    private function redirectBasedOnRole($user)
    {
        if (!$user) {
            abort(403, 'Unauthorized role.');
        }

        // Redirect based on specific role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'manager':
                return redirect()->route('manager.dashboard');
            case 'cashier':
                return redirect()->route('cashier.dashboard');
            case 'customer':
                return redirect()->route('homepage.index');
            default:
                abort(403, 'Unauthorized role.');
        }
    }

    /**
     * Get the currently authenticated user from any guard
     */
    private function getAuthenticatedUser()
    {
        foreach (['admin', 'manager', 'cashier', 'customer', 'web'] as $guard) {
            if (Auth::guard($guard)->check()) {
                return Auth::guard($guard)->user();
            }
        }
        return null;
    }

    /**
     * Show login form
     */
    public function showLoginForm()
    {
        if ($user = $this->getAuthenticatedUser()) {
            return $this->redirectBasedOnRole($user);
        }

        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        foreach (['admin', 'manager', 'cashier', 'customer'] as $guard) {
            if (Auth::guard($guard)->attempt($credentials, $request->remember)) {
                $request->session()->regenerate();
                return $this->redirectBasedOnRole(Auth::guard($guard)->user());
            }
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    /**
     * Show register form
     */
    public function showRegisterForm()
    {
        if ($user = $this->getAuthenticatedUser()) {
            return $this->redirectBasedOnRole($user);
        }

        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'role'                  => 'sometimes|in:customer,admin'
        ]);

        User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'role'           => $request->role ?? 'customer',
            'picture_url'    => null,
            'remember_token' => Str::random(60),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful.');
    }

    /**
     * Update profile picture
     */
    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = $this->getAuthenticatedUser();

        if (!$user) {
            return back()->withErrors(['profile_picture' => 'No authenticated user found.']);
        }

        if ($user->picture_url) {
            Storage::disk('public')->delete($user->picture_url);
        }

        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $user->picture_url = $path;
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile picture updated successfully.');
    }

    /**
     * Logout user from all guards
     */
    public function logout()
    {
        session()->forget(config('services.google.token_name'));

        foreach (['admin', 'manager', 'cashier', 'customer', 'web'] as $guard) {
            Auth::guard($guard)->logout();
        }

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}
