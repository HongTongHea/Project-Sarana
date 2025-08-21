<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Category;
use App\Models\Accessory;

class DashboardController extends Controller
{
    /**
     * Get the currently authenticated user from any guard
     */
    private function getAuthenticatedUser()
    {
        foreach (['admin', 'manager', 'cashier', 'customer', 'web'] as $guard) {
            if (Auth::guard($guard)->check()) {
                return Auth::guard($guard)->user();
            }
        }
        return null;
    }

    /**
     * Show admin dashboard
     */
    public function adminDashboard()
    {
        $user = $this->getAuthenticatedUser();

        if (!$user || $user->role !== 'admin') {
            return redirect()->route('login');
        }

        // Admin sees all data
        $users = User::all();
        $customers = Customer::all();
        $orders = Order::all();
        $products = Product::all();
        $stocks = Stock::all();
        $categories = Category::all();
        $accessories = Accessory::all();

        return view('admin.dashboard', compact(
            'users',
            'customers',
            'orders',
            'products',
            'stocks',
            'categories',
            'accessories'
        ));
    }

    /**
     * Show manager dashboard
     */
    public function managerDashboard()
    {
        $user = $this->getAuthenticatedUser();

        if (!$user || $user->role !== 'manager') {
            return redirect()->route('login');
        }

        // Manager sees limited data (example: exclude sensitive user info)
        $users = User::all();
        $customers = Customer::all();
        $orders = Order::all();
        $products = Product::all();
        $stocks = Stock::all();
        $categories = Category::all();
        $accessories = Accessory::all();

        return view('manager.dashboard', compact(
            'users',
            'customers',
            'orders',
            'products',
            'stocks',
            'categories',
            'accessories'
        ));
    }

    /**
     * Show cashier dashboard
     */
    public function cashierDashboard()
    {
        $user = $this->getAuthenticatedUser();

        if (!$user || $user->role !== 'cashier') {
            return redirect()->route('login');
        }

        // Cashier sees only what they need (orders and products)
        $orders = Order::where('status', 'pending')->get();
        $products = Product::where('stock', '>', 0)->get();

        return view('cashier.dashboard', compact(
            'orders',
            'products'
        ));
    }

    /**
     * Legacy method for backward compatibility
     */
    public function dashboard()
    {
        $user = $this->getAuthenticatedUser();

        if (!$user) {
            return redirect()->route('login');
        }

        // Redirect to appropriate dashboard based on role
        switch ($user->role) {
            case 'admin':
                return $this->adminDashboard();
            case 'manager':
                return $this->managerDashboard();
            case 'cashier':
                return $this->cashierDashboard();
            case 'customer':
                return redirect()->route('homepage.index');
            default:
                abort(403, 'Unauthorized action.');
        }
    }
}
