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
    private function redirectBasedOnRole($user)
    {
        if (!$user) {
            abort(403, 'Unauthorized role.');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'customer') {
            return redirect()->route('homepage.index');
        }

        abort(403, 'Unauthorized role.');
    }

    public function showLoginForm()
    {
        // If already logged in as admin/customer, redirect them
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        if (Auth::guard('customer')->check()) {
            return redirect()->route('homepage.index');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        // Try find user first
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        // Choose guard automatically based on role
        $guard = $user->role === 'admin' ? 'admin' : 'customer';

        if (Auth::guard($guard)->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole(Auth::guard($guard)->user());
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function showRegisterForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        if (Auth::guard('customer')->check()) {
            return redirect()->route('homepage.index');
        }

        return view('auth.register');
    }

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

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = Auth::guard('admin')->user() ?? Auth::guard('customer')->user();

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

    public function logout()
    {
        // Clear Google OAuth session (if used)
        session()->forget(config('services.google.token_name'));

        // Logout from all guards
        Auth::guard('admin')->logout();
        Auth::guard('customer')->logout();
        Auth::logout(); // Default guard logout as fallback

        // Invalidate session & regenerate CSRF token
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/'); // Redirect to homepage after logout
    } 
}
