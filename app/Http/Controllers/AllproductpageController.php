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
}
