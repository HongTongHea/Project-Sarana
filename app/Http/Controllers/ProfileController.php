<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user(); // works because of auth:admin,customer middleware

        if (!$user) {
            abort(403, 'Unauthorized'); // Safety net
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('picture')) {
            if ($user->picture_url) {
                Storage::disk('public')->delete($user->picture_url);
            }
            $path = $request->file('picture')->store('profile_pictures', 'public');
            $user->picture_url = $path;
        }

        $user->save();

        return redirect()->route('homepage.index')->with('success', 'Profile updated successfully.');
    }
}
