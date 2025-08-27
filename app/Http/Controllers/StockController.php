<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Accessory;
use App\Models\Stock;

class StockController extends Controller
{
    public function index()
    {
        // Get all products and accessories with their stock history
        $products = Product::with(['stocks' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();

        $accessories = Accessory::with(['stocks' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();

        // Combine and format the data
        $currentStocks = [];

        // Process products
        foreach ($products as $product) {
            $latestStock = $product->stocks->first();
            $initialStock = $product->stocks()->where('type', 'initial')->first();

            // Calculate total purchases and sales separately
            $totalPurchases = $product->stocks()->where('type', 'purchase')->sum('change_amount');
            $totalSales = abs($product->stocks()->where('type', 'sale')->sum('change_amount'));

            // Net change (purchases are positive, sales are negative)
            $netChange = $totalPurchases - $totalSales;

            $currentStocks[] = [
                'stockable' => $product,
                'stockable_type' => get_class($product),
                'current_quantity' => $latestStock ? $latestStock->quantity : $product->stock_quantity,
                'initial_quantity' => $initialStock ? $initialStock->quantity : $product->stock_quantity,
                'total_purchases' => $totalPurchases,
                'total_sales' => $totalSales,
                'net_change' => $netChange,
                'last_updated' => $latestStock ? $latestStock->updated_at : now()
            ];
        }

        // Process accessories
        foreach ($accessories as $accessory) {
            $latestStock = $accessory->stocks->first();
            $initialStock = $accessory->stocks()->where('type', 'initial')->first();

            // Calculate total purchases and sales separately
            $totalPurchases = $accessory->stocks()->where('type', 'purchase')->sum('change_amount');
            $totalSales = abs($accessory->stocks()->where('type', 'sale')->sum('change_amount'));

            // Net change (purchases are positive, sales are negative)
            $netChange = $totalPurchases - $totalSales;

            $currentStocks[] = [
                'stockable' => $accessory,
                'stockable_type' => get_class($accessory),
                'current_quantity' => $latestStock ? $latestStock->quantity : $accessory->stock_quantity,
                'initial_quantity' => $initialStock ? $initialStock->quantity : $accessory->stock_quantity,
                'total_purchases' => $totalPurchases,
                'total_sales' => $totalSales,
                'net_change' => $netChange,
                'last_updated' => $latestStock ? $latestStock->updated_at : now()
            ];
        }

        // Sort by last updated
        $currentStocks = collect($currentStocks)->sortByDesc('last_updated');

        return view('stocks.index', compact('currentStocks'));
    }
}
