<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;

class ProductpageController extends Controller
{
    public function index()
    {
        $products = Product::where('stock_quantity', '>', 0)->get();
        $categories = Category::all();
        return view('productpage', compact('products', 'categories'));
    }
}
