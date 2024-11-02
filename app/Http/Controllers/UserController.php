<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        return view('dashboard', compact('user'));
    }

    public function show($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Return the view with the user data
        return view('users.show', compact('user'));
    }

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed',
            'profile_picture' => 'image|nullable|max:1999',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::delete('public/' . $user->profile_picture); // Correctly deleting the old profile picture
            }
            $user->profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user->save();

        return redirect()->route('dashboard')->with('success', 'Profile updated successfully'); // Redirect to dashboard
    }

    public function destroy(User $user)
    {
        if ($user->profile_picture) {
            Storage::delete('public/images/' . $user->profile_picture); // Correct path
        }
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
