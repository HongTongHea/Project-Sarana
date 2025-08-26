<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Accessory;

class StockController extends Controller
{
    public function index()
    {
        // Get all products and accessories with their latest stock records
        $products = Product::with(['stocks' => function ($query) {
            $query->latest()->limit(1);
        }])->get();

        $accessories = Accessory::with(['stocks' => function ($query) {
            $query->latest()->limit(1);
        }])->get();

        // Combine and format the data
        $currentStocks = [];

        // Process products
        foreach ($products as $product) {
            $latestStock = $product->stocks->first();
            $initialStock = $product->stocks()->where('type', 'initial')->first();

            $currentStocks[] = [
                'stockable' => $product,
                'stockable_type' => get_class($product),
                'current_quantity' => $latestStock ? $latestStock->quantity : $product->stock_quantity,
                'initial_quantity' => $initialStock ? $initialStock->quantity : $product->stock_quantity,
                'last_updated' => $latestStock ? $latestStock->updated_at : now()
            ];
        }

        // Process accessories
        foreach ($accessories as $accessory) {
            $latestStock = $accessory->stocks->first();
            $initialStock = $accessory->stocks()->where('type', 'initial')->first();

            $currentStocks[] = [
                'stockable' => $accessory,
                'stockable_type' => get_class($accessory),
                'current_quantity' => $latestStock ? $latestStock->quantity : $accessory->stock_quantity,
                'initial_quantity' => $initialStock ? $initialStock->quantity : $accessory->stock_quantity,
                'last_updated' => $latestStock ? $latestStock->updated_at : now()
            ];
        }

        // Sort by last updated
        $currentStocks = collect($currentStocks)->sortByDesc('last_updated');

        return view('stocks.index', compact('currentStocks'));
    }
}
