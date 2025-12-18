<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Accessory;
use App\Models\Category;

class AllproductpageController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $accessories = Accessory::all();
        $categories = Category::all();

        return view('allproductpage', [
            'products' => $products,
            'accessories' => $accessories,
            'categories' => $categories,
            'showProducts' => false,
        ]);
    }

    public function checkUpdates()
    {
        // Get count AND latest update timestamp
        $productCount = Product::count();
        $accessoryCount = Accessory::count();
        
        // Get the most recent update time
        $latestProductUpdate = Product::max('updated_at');
        $latestAccessoryUpdate = Accessory::max('updated_at');
        
        return response()->json([
            'success' => true,
            'productCount' => $productCount,
            'accessoryCount' => $accessoryCount,
            'latestProductUpdate' => $latestProductUpdate,
            'latestAccessoryUpdate' => $latestAccessoryUpdate,
            'timestamp' => now()->toDateTimeString()
        ]);
    }
}
