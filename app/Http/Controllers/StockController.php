<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all stock entries grouped by stockable type and ID
        $stocks = Stock::with(['stockable'])
            ->get()
            ->groupBy(['stockable_type', 'stockable_id']);

        // Calculate current quantities
        $currentStocks = [];

        foreach ($stocks as $type => $items) {
            foreach ($items as $id => $stockRecords) {
                $currentQuantity = 0;

                foreach ($stockRecords as $record) {
                    if ($record->type === 'initial') {
                        $currentQuantity += $record->quantity;
                    } elseif ($record->type === 'update') {
                        $currentQuantity = $record->quantity; // Updates replace the quantity
                    }
                }

                if ($stockRecords->first()->stockable) {
                    $currentStocks[] = [
                        'stockable' => $stockRecords->first()->stockable,
                        'stockable_type' => $type,
                        'current_quantity' => $currentQuantity,
                        'initial_quantity' => $stockRecords->firstWhere('type', 'initial')->quantity ?? 0,
                        'last_updated' => $stockRecords->sortByDesc('created_at')->first()->created_at
                    ];
                }
            }
        }

        // Sort by latest updated
        $currentStocks = collect($currentStocks)->sortByDesc('last_updated');

        return view('stocks.index', compact('currentStocks'));
    }
}
