<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Category;
use App\Models\Accessory;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use App\Models\OnlineOrder;

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

    private function getGreeting()
    {
        $hour = now('Asia/Phnom_Penh')->format('H'); // Cambodia local hour

        if ($hour < 12) {
            return 'Good Morning';
        } elseif ($hour < 17) {
            return 'Good Afternoon';
        } else {
            return 'Good Evening';
        }
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
        $sales = Sale::all();
        $products = Product::all();
        $stocks = Stock::all();
        $categories = Category::all();
        $accessories = Accessory::all();
        $onlineOrders = OnlineOrder::all();

        $totalSales = $sales->sum('total');
        // Calculate total stock value
        $totalStockValue = 0;

        foreach ($products as $product) {
            $totalStockValue += $product->stock_quantity * ($product->price ?? 0);
        }

        foreach ($accessories as $accessory) {
            $totalStockValue += $accessory->stock_quantity * ($accessory->price ?? 0);
        }

        // Real stock movement data for the last 30 days
        $stockMovementDates = [];
        $productStockData = [];
        $accessoryStockData = [];

        // Get current stock levels
        $currentProductStock = Product::sum('stock_quantity');
        $currentAccessoryStock = Accessory::sum('stock_quantity');

        // Build data for each day (going backwards from today)
        for ($i = 0; $i <= 30; $i++) {
            $date = now()->subDays($i);
            $dateString = $date->format('M j');

            // For real implementation, you would query the stock levels for each specific date
            // This is a simplified version that uses the current stock minus recent changes
            $daysAgo = $i;

            // Calculate estimated stock for this date based on recent changes
            $productStockForDate = $this->calculateStockForDate(Product::class, $date);
            $accessoryStockForDate = $this->calculateStockForDate(Accessory::class, $date);

            $stockMovementDates[] = $dateString;
            $productStockData[] = $productStockForDate;
            $accessoryStockData[] = $accessoryStockForDate;
        }

        // Reverse the arrays to show chronological order
        $stockMovementDates = array_reverse($stockMovementDates);
        $productStockData = array_reverse($productStockData);
        $accessoryStockData = array_reverse($accessoryStockData);

        $greeting = $this->getGreeting();

        return view('admin.dashboard', compact(
            'users',
            'customers',
            'sales',
            'products',
            'stocks',
            'categories',
            'accessories',
            'greeting',
            'user',
            'onlineOrders',
            'totalStockValue',
            'stockMovementDates',
            'productStockData',
            'accessoryStockData',
            'totalSales',
        ));
    }

    /**
     * Calculate stock quantity for a specific date
     */
    private function calculateStockForDate($stockableType, $date)
    {
        // Get the latest stock record for each item before the given date
        $latestStockRecords = Stock::where('stockable_type', $stockableType)
            ->whereDate('created_at', '<=', $date)
            ->get()
            ->groupBy('stockable_id')
            ->map(function ($records) {
                return $records->sortByDesc('created_at')->first();
            });

        return $latestStockRecords->sum('quantity');
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
        $sales = Sale::all();
        $products = Product::all();
        $stocks = Stock::all();
        $categories = Category::all();
        $accessories = Accessory::all();

        $greeting = $this->getGreeting();

        return view('manager.dashboard', compact(
            'users',
            'customers',
            'sales',
            'products',
            'stocks',
            'categories',
            'accessories',
            'greeting'
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
        $sales = Sale::where('status', 'pending')->get();
        $products = Product::where('stock', '>', 0)->get();

        return view('cashier.dashboard', compact(
            'sales',
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
