<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Accessory;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');

        $products = Product::where('stock_quantity', '>', 0)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('stock_no', 'like', "%{$search}%");
            })
            ->get();

        $accessories = Accessory::where('stock_quantity', '>', 0)
            ->where('name', 'like', "%{$search}%")
            ->get();

        return response()->json([
            'products' => $products,
            'accessories' => $accessories
        ]);
    }
}
