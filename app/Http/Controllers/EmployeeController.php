<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function showDetail(Request $request)
    {
        $employeeId = $request->query('id');
        $employee = Employee::findOrFail($employeeId);

        return view('employees.detail', [
            'employee' => $employee,
            'name' => $request->query('name'),
            'position' => $request->query('position'),
            'picture_url' => $request->query('picture_url')
        ]);
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:employees',
            'phone' => 'required|string|max:191',
            'address' => 'required|string|max:191',
            'position' => 'required|string|max:191',
            'picture_url' => 'image|nullable|mimes:jpg,jpeg,png,gif,bmp,tiff|max:30000',
            'status' => 'sometimes|integer',
        ]);

        $employee = new Employee($request->except('picture_url'));

        if ($request->hasFile('picture_url')) {
            $employee->picture_url = $request->file('picture_url')->store('employee_photos', 'public');
        }

        $employee->save();

        return redirect()->route('employees.index')->with('success', 'Employee created successfully');
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:191',
            'email' => 'sometimes|required|string|email|max:191|unique:employees,email,' . $employee->id,
            'phone' => 'sometimes|required|string|max:191',
            'address' => 'sometimes|required|string|max:191',
            'position' => 'sometimes|required|string|max:191',
            'picture_url' => 'nullable|image|mimes:jpg,jpeg,png,gif,bmp,tiff|max:30000',
            'status' => 'sometimes|integer',
        ]);

        $employee->update($request->except('picture_url'));

        if ($request->hasFile('picture_url')) {
            if ($employee->picture_url && Storage::exists('public/' . $employee->picture_url)) {
                Storage::delete('public/' . $employee->picture_url);
            }
            $employee->picture_url = $request->file('picture_url')->store('employee_photos', 'public');
            $employee->save();
        }

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        if ($employee->picture_url) {
            Storage::delete('public/' . $employee->picture_url);
        }

        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully');
    }
}
