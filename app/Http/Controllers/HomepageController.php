<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Stock;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Accessory;

class HomepageController extends Controller
{
    //
    public function index()
    {
        $products = Product::where('stock_quantity', '>', 0)->get();
        $accessories = Accessory::where('stock_quantity', '>', 0)->get();
        $categories = Category::all();

        return view('homepage', compact('products', 'accessories', 'categories'));
    }
}
