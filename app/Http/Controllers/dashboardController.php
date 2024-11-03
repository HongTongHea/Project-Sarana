<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return view('admin.dashboard');
        } elseif ($user->isCustomer()) {
            return view('customer.dashboard');
        } elseif ($user->isStaff()) {
            return view('staff.dashboard');
        }

        // Optionally, handle cases where the role does not match
        abort(403, 'Unauthorized action.');
    }
}
