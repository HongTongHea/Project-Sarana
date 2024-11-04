<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
    
        if ($user->isAdmin()) {
            // Fetch all users for the admin dashboard
            $users = User::all();
            return view('admin.dashboard', compact('users'));
        } elseif ($user->isCustomer()) {
            return view('customer.dashboard', compact('user'));
        } elseif ($user->isStaff()) {
            return view('staff.dashboard', compact('user'));
        }
    
        // Optionally, handle cases where the role does not match
        abort(403, 'Unauthorized action.');
    }
    
}
