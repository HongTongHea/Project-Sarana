<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
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

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard')->with('success', 'Login successful.');
        }
        return back()->withErrors(['email' => 'Invalid email or password.']);
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
            return redirect()->route('login');
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
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer', // Default role for new users
            'picture_url' => null, // Default picture URL
        ]);

        return redirect()->route('login')->with('success', 'Registration successful.');
    }




    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();


        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Create a new user if not found
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => Hash::make(uniqid()),
                'role' => 'customer',
                'picture_url' => $googleUser->getAvatar(),

            ]);
        }

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Login successful.');
    }

    // public function redirectToFacebook()
    // {
    //     return Socialite::driver('facebook')->redirect();
    // }

    // public function handleFacebookCallback()
    // {
    //     $facebookUser = Socialite::driver('facebook')->user();

    //     $user = User::where('email', $facebookUser->getEmail())->first();

    //     if (!$user) {
    //         // Create a new user if not found
    //         $user = User::create([
    //             'name' => $facebookUser->getName(),
    //             'email' => $facebookUser->getEmail(),
    //             'password' => Hash::make(uniqid()), // Generate a random password for Facebook login users
    //             'picture_url' => $facebookUser->getAvatar(),
    //         ]);
    //     }

    //     Auth::login($user);

    //     return redirect()->route('dashboard')->with('success', 'Login successful.');
    // }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Successfully logged out.');
    }
}
