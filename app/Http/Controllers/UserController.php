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
        // Fetch all users from the database
        $users = User::all();

        // Pass users data to the dashboard view
        return view('dashboard', compact('users'));
    }

    public function index(Request $request)
    {
        $users = User::all();

        // Check if `edit` parameter is present to load the user data for editing
        $user = null;
        if ($request->has('edit')) {
            $user = User::find($request->input('edit'));
        }

        return view('users.index', compact('users', 'user'));
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
            'picture_url' => 'image|nullable|mimes:jpg,jpeg,png,gif,bmp,tiff,pdf,doc,docx,xlsx,xls|30000',
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->role = $validatedData['role'];
        $user->password = Hash::make($validatedData['password']);

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
            'picture_url' => 'image|nullable|mimes:jpg,jpeg,png,gif,bmp,tiff,pdf,doc,docx,xlsx,xls|30000',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
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
