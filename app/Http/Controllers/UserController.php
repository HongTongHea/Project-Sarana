<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class UserController extends Controller

{


    public function dashboard()
    {
        // Fetch all users from the database
        $users = User::latest()->get();

        // Pass users data to the dashboard view
        return view('dashboard', compact('users'));
    }

    protected function getAuthenticatedUser()
    {
        return Auth::user();
    }

    public function index(Request $request)
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|in:admin,manager,cashier,customer',
            'picture_url' => 'image|nullable|mimes:jpg,jpeg,png,gif,bmp,tiff,pdf,doc,docx,xlsx,xls|max:30000',
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->role = $validatedData['role'];

        // ✅ Hash password before saving
        $user->password = Hash::make($validatedData['password']);

        // Generate a random remember token
        $user->remember_token = Str::random(60);

        if ($request->hasFile('picture_url')) {
            $user->picture_url = $request->file('picture_url')->store('picture_url', 'public');
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }



    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }



    /**
     * Update profile picture
     */
    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = $this->getAuthenticatedUser(); // Now this will work

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

    public function showProfile()
    {
    $user = Auth::user(); 
    
    if (!$user) {
        return redirect()->route('login')->with('error', 'Please login to view your profile.');
    }
    
    return view('users.show', compact('user'));
    }
    
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:8',
            'role' => 'required|in:admin,manager,cashier,customer',
            'picture_url' => 'image|nullable|mimes:jpg,jpeg,png,gif,bmp,tiff,pdf,doc,docx,xlsx,xls|max:30000',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            // ✅ Hash new password before saving
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('picture_url')) {
            if ($user->picture_url) {
                Storage::delete('public/' . $user->picture_url);
            }
            $user->picture_url = $request->file('picture_url')->store('picture_url', 'public');
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Profile updated successfully');
    }


    public function destroy(User $user)
    {
        if ($user->picture_url) {
            Storage::delete('public/' . $user->picture_url);
        }
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
