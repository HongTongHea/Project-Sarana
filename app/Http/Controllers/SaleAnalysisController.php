<?php

namespace App\Http\Controllers;

use App\Models\SaleAnalysis;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Accessory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SaleAnalysisController extends Controller
{
    // public function __construct()
    // {
    //     // Apply auth middleware to all methods
    //     $this->middleware('auth:admin,manager,cashier');
    // }
    
    public function index(Request $request)
    {
        // Get period from request or default to 'all'
        $period = $request->get('period', 'all');
        
        // Get top items by revenue
        $topByRevenue = $this->getTopItemsByRevenue(10, $period);
        
        // Get top items by quantity
        $topByQuantity = $this->getTopItemsByQuantity(10, $period);
        
        // Get sales summary
        $summary = $this->getSalesSummary($period);
        
        // Load item details for top items
        $topByRevenue = $this->loadItemDetails($topByRevenue);
        $topByQuantity = $this->loadItemDetails($topByQuantity);

        return view('sale-analysis.index', compact(
            'topByRevenue',
            'topByQuantity',
            'summary',
            'period'
        ));
    }

    public function topItemsReport(Request $request)
    {
        $period = $request->get('period', 'all');
        $sortBy = $request->get('sort_by', 'revenue');
        
        if ($sortBy === 'quantity') {
            $topItems = $this->getTopItemsByQuantity(50, $period);
        } else {
            $topItems = $this->getTopItemsByRevenue(50, $period);
        }
        
        $topItems = $this->loadItemDetails($topItems);
        
        return view('sale-analysis.report', compact('topItems', 'period', 'sortBy'));
    }

    public function itemDetail($itemType, $itemId, Request $request)
    {
        $period = $request->get('period', 'all');
        
        // Get item sales history
        $salesHistory = SaleItem::where('item_type', $itemType)
            ->where('item_id', $itemId)
            ->when($period !== 'all', function ($query) use ($period) {
                $dateFilter = $this->getDateFilter($period);
                return $query->where('created_at', '>=', $dateFilter);
            })
            ->with('sale')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        // Get item summary
        $itemSummary = SaleItem::where('item_type', $itemType)
            ->where('item_id', $itemId)
            ->when($period !== 'all', function ($query) use ($period) {
                $dateFilter = $this->getDateFilter($period);
                return $query->where('created_at', '>=', $dateFilter);
            })
            ->selectRaw('
                SUM(quantity) as total_quantity,
                SUM(total) as total_revenue,
                AVG(price) as average_price,
                AVG(discount_percentage) as average_discount,
                COUNT(DISTINCT sale_id) as sale_count
            ')
            ->first();
        
        // Load item details
        $item = $this->loadSingleItem($itemType, $itemId);
        
        return view('sale-analysis.item-detail', compact(
            'item',
            'salesHistory',
            'itemSummary',
            'period'
        ));
    }

    /**
     * Get top items by revenue
     */
    private function getTopItemsByRevenue($limit = 10, $period = 'all')
    {
        $query = SaleItem::query()
            ->selectRaw('
                item_type,
                item_id,
                SUM(quantity) as total_quantity,
                SUM(total) as total_revenue,
                COUNT(DISTINCT sale_id) as sale_count
            ')
            ->groupBy('item_type', 'item_id')
            ->orderByDesc('total_revenue')
            ->limit($limit);

        if ($period !== 'all') {
            $dateFilter = $this->getDateFilter($period);
            $query->where('created_at', '>=', $dateFilter);
        }

        return $query->get();
    }

    /**
     * Get top items by quantity
     */
    private function getTopItemsByQuantity($limit = 10, $period = 'all')
    {
        $query = SaleItem::query()
            ->selectRaw('
                item_type,
                item_id,
                SUM(quantity) as total_quantity,
                SUM(total) as total_revenue,
                COUNT(DISTINCT sale_id) as sale_count
            ')
            ->groupBy('item_type', 'item_id')
            ->orderByDesc('total_quantity')
            ->limit($limit);

        if ($period !== 'all') {
            $dateFilter = $this->getDateFilter($period);
            $query->where('created_at', '>=', $dateFilter);
        }

        return $query->get();
    }

    /**
     * Get sales summary
     */
    private function getSalesSummary($period = 'all')
    {
        $query = SaleItem::query()
            ->selectRaw('
                COUNT(DISTINCT sale_id) as total_sales,
                SUM(quantity) as total_items_sold,
                SUM(total) as total_revenue,
                AVG(total) as average_sale_value
            ');

        if ($period !== 'all') {
            $dateFilter = $this->getDateFilter($period);
            $query->where('created_at', '>=', $dateFilter);
        }

        return $query->first();
    }

    /**
     * Get date filter based on period
     */
    private function getDateFilter($period)
    {
        return match($period) {
            'today' => now()->startOfDay(),
            'week' => now()->subWeek(),
            'month' => now()->subMonth(),
            'year' => now()->subYear(),
            default => now()->subMonth(),
        };
    }

    /**
     * Load item details for a collection of items
     */
    private function loadItemDetails($items)
    {
        foreach ($items as $item) {
            $item->details = $this->loadSingleItem($item->item_type, $item->item_id);
        }
        
        return $items;
    }

    /**
     * Load a single item by type and ID
     */
    private function loadSingleItem($itemType, $itemId)
    {
        try {
            if ($itemType === 'App\Models\Product') {
                return Product::find($itemId);
            } elseif ($itemType === 'App\Models\Accessory') {
                return Accessory::find($itemId);
            }
        } catch (\Exception $e) {
            // Log error if needed
            \Log::error('Error loading item: ' . $e->getMessage());
        }
        
        return null;
    }
}