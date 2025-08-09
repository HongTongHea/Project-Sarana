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
    public function dashboard()
    {
        // Only admins should see admin dashboard
        $user = Auth::guard('admin')->user();

        if ($user && $user->role === 'admin') {
            $users = User::all();
            $customers = Customer::all();
            $orders = Order::all();
            $products = Product::all();
            $stocks = Stock::all();
            $categories = Category::all();
            $accessories = Accessory::all();

            return view('admin.dashboard', compact('users', 'customers', 'orders', 'products', 'stocks', 'categories', 'accessories'));
        }

        // Customers (or unauthenticated) visiting this route will be redirected
        if (Auth::guard('customer')->check()) {
            return redirect()->route('homepage.index');
        }

        abort(403, 'Unauthorized action.');
    }
}
