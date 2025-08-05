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
        $user = Auth::user();

        if ($user && $user->isAdmin()) {

            $users = User::all();
            $customers = Customer::all();
            $orders = Order::all();
            $products = Product::all();
            $stocks = Stock::all();
            $categories = Category::all();
            $accessories = Accessory::all();

            return view('admin.dashboard', compact('users', 'customers', 'orders', 'products', 'stocks', 'categories', 'accessories'));
        } elseif ($user && $user->role === 'customer') {
            return redirect()->route('homepage.index');
        }

        // If no user or role doesn't match
        abort(403, 'Unauthorized action.');
    }
}
