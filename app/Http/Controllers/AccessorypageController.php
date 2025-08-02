<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Accessory;
use App\Models\Category;

class AccessorypageController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $accessories = Accessory::all();
        $categories = Category::all();

        return view('accessorypage', [
            'products' => $products,
            'accessories' => $accessories,
            'categories' => $categories,
            'showProducts' => false, 
        ]);
    }
}
