<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = Staff::with('user')->get();
        return view('staffs.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('staffs.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        $staffs = Staff::all();
        $users = User::all();
        return view('staffs.edit', compact('staff', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        //
        $staff->delete();
        return redirect()->route('staffs.index')->with('success', 'Staff deleted successfully.');
    }
}
