<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;



class AuthController extends Controller
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

    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return response()
            ->view('auth.login')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function viewUsers()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }


    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = Auth::user();


        if ($user->picture_url) {
            Storage::disk('public')->delete($user->picture_url);
        }

        // Store the new picture
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $user->picture_url = $path;
        $user->save();

        return redirect()->route('users.show', $user->id)->with('success', 'Profile picture updated successfully.');
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return response()
            ->view('auth.register')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'role' => 'sometimes|in:customer,admin' // Add this line
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'customer', // Modified this line
            'picture_url' => null,
        ]);

        return redirect()->route('login')->with('success', 'Registration successful.');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Check the previous URL to determine where to redirect
        if (str_contains($request->headers->get('referer'), 'admin')) {
            return redirect()->route('login')->with("success", "You have been logged out.");
        }

        return redirect('/');
    }
}
