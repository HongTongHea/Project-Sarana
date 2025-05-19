<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {   
        $users = User::all();
        $staffs = Staff::with('user')->get();
        return view('staffs.index', compact('staffs', 'users'));
    }

 
    public function create()
    {
        $users = User::all();
        return view('staffs.create', compact('users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'gender' => 'required|in:Male,Female',
            'position' => 'required|string',
            'department' => 'required|string',
            'salary' => 'required|numeric',
            'date_hired' => 'required|date',
            'contact_number' => 'required|string',
            'address' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        Staff::create($request->all());
        return redirect()->route('staffs.index')->with('success', 'Staff created successfully.');
    }

    public function edit(Staff $staff)
    {
        $staffs = Staff::all();
        $users = User::all();
        return view('staffs.edit', compact('staff', 'users'));
    }

   
    public function update(Request $request, Staff $staff)
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'gender' => 'required|in:Male,Female',
            'position' => 'required|string',
            'department' => 'required|string',
            'salary' => 'required|numeric',
            'date_hired' => 'required|date',
            'contact_number' => 'required|string',   
            'address' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        $staff->update($request->all());

        return redirect()->route('staffs.index')->with('success', 'Staff updated successfully.');
    }


    public function destroy(Staff $staff)
    {   
        $staff->delete();
        return redirect()->route('staffs.index')->with('success', 'Staff deleted successfully.');
    }
}
