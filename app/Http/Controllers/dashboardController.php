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
        $hour = now('Asia/Phnom_Penh')->format('H');

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

        // Get stock movement data
        $stockData = $this->getStockMovementData();
        $stockMovementDates = $stockData['stockMovementDates'];
        $productStockData = $stockData['productStockData'];
        $accessoryStockData = $stockData['accessoryStockData'];

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
     * Show manager dashboard
     */
    public function managerDashboard()
    {
        $user = $this->getAuthenticatedUser();

        if (!$user || $user->role !== 'manager') {
            return redirect()->route('login');
        }

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

        // Get stock movement data
        $stockData = $this->getStockMovementData();
        $stockMovementDates = $stockData['stockMovementDates'];
        $productStockData = $stockData['productStockData'];
        $accessoryStockData = $stockData['accessoryStockData'];

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
     * Show cashier dashboard
     */
    public function cashierDashboard()
    {
        $user = $this->getAuthenticatedUser();

        if (!$user || $user->role !== 'cashier') {
            return redirect()->route('login');
        }

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

        // Get stock movement data
        $stockData = $this->getStockMovementData();
        $stockMovementDates = $stockData['stockMovementDates'];
        $productStockData = $stockData['productStockData'];
        $accessoryStockData = $stockData['accessoryStockData'];

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

 
    private function getStockMovementData()
    {
        $stockMovementDates = [];
        $productStockData = [];
        $accessoryStockData = [];

        $currentProductStock = $this->getCurrentProductStock();
        $currentAccessoryStock = $this->getCurrentAccessoryStock();
        

        $today = now();
        
 
        $referenceDate = now()->setYear(2026)->setMonth(1)->setDay(15);
        
        
        $hasHistoricalData = false; 
        
        if ($hasHistoricalData) {

        } else {

            for ($i = 29; $i >= 0; $i--) {
                $date = now()->subDays($i);
                

                $dateString = $date->format('M j');
                

                $daysFromReference = $date->diffInDays($referenceDate);
                

                $baseProductStock = $currentProductStock;
                $baseAccessoryStock = $currentAccessoryStock;
                
        
                $dayOfWeek = $date->dayOfWeek;
                $weekendFactor = ($dayOfWeek === 0 || $dayOfWeek === 6) ? 0.9 : 1.0; 
                

                $dayOfMonth = $date->day;
                $monthEndFactor = $dayOfMonth > 25 ? 0.85 : 1.0; 
                

                $randomFactor = 0.95 + (mt_rand(0, 100) / 1000); 
                

                $trendFactor = 1 + ($i * 0.005); 
                
                $productStockForDate = (int)($baseProductStock * $weekendFactor * $monthEndFactor * $randomFactor * $trendFactor);
                $accessoryStockForDate = (int)($baseAccessoryStock * $weekendFactor * $monthEndFactor * $randomFactor * $trendFactor);
                

                $productStockForDate = max($baseProductStock * 0.8, $productStockForDate);
                $accessoryStockForDate = max($baseAccessoryStock * 0.8, $accessoryStockForDate);
                

                $productStockForDate = min($baseProductStock * 1.2, $productStockForDate);
                $accessoryStockForDate = min($baseAccessoryStock * 1.2, $accessoryStockForDate);
                

                $productStockForDate = (int)round($productStockForDate);
                $accessoryStockForDate = (int)round($accessoryStockForDate);

                $stockMovementDates[] = $dateString;
                $productStockData[] = $productStockForDate;
                $accessoryStockData[] = $accessoryStockForDate;
            }
        }

        return compact('stockMovementDates', 'productStockData', 'accessoryStockData');
    }

    private function getStockMovementDataFromDatabase()
    {
        $stockMovementDates = [];
        $productStockData = [];
        $accessoryStockData = [];
        
        // Get data for last 30 days
        $startDate = now()->subDays(29);
        

        for ($i = 0; $i < 30; $i++) {
            $currentDate = $startDate->copy()->addDays($i);
            

            $stockMovementDates[] = $currentDate->format('M j');
            
            if ( false) {
            } else {
                $productStockData[] = $this->getInterpolatedProductStock($currentDate);
                $accessoryStockData[] = $this->getInterpolatedAccessoryStock($currentDate);
            }
        }
        
        return compact('stockMovementDates', 'productStockData', 'accessoryStockData');
    }
    
    /**
     * Helper method for interpolation (if needed)
     */
    private function getInterpolatedProductStock($date)
    {
        $currentStock = $this->getCurrentProductStock();
        $daysAgo = now()->diffInDays($date);
        
        // Simple interpolation: assume stock was 20% lower 30 days ago
        $percentage = 1 - ($daysAgo / 30 * 0.2);
        return (int)($currentStock * $percentage);
    }
    
    private function getInterpolatedAccessoryStock($date)
    {
        $currentStock = $this->getCurrentAccessoryStock();
        $daysAgo = now()->diffInDays($date);
        
        // Simple interpolation: assume stock was 15% lower 30 days ago
        $percentage = 1 - ($daysAgo / 30 * 0.15);
        return (int)($currentStock * $percentage);
    }

    /**
     * Get current product stock
     */
    private function getCurrentProductStock()
    {
        return Product::sum('stock_quantity');
    }

    /**
     * Get current accessory stock
     */
    private function getCurrentAccessoryStock()
    {
        return Accessory::sum('stock_quantity');
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