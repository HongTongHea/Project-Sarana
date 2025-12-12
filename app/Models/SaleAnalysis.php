<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SaleAnalysis extends Model
{
    protected $table = 'sale_items'; // We'll query from sale_items table
    
    // Since we're not creating a new table, we'll use this as a query builder
    public static function getTopItemsByRevenue($limit = 10, $period = 'all')
    {
        $query = SaleItem::query()
            ->select([
                'item_type',
                'item_id',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(total) as total_revenue'),
                DB::raw('COUNT(DISTINCT sale_id) as sale_count')
            ])
            ->groupBy('item_type', 'item_id')
            ->orderByDesc('total_revenue')
            ->limit($limit);

        // Apply time period filters if needed
        if ($period !== 'all') {
            $dateFilter = match($period) {
                'today' => now()->startOfDay(),
                'week' => now()->subWeek(),
                'month' => now()->subMonth(),
                'year' => now()->subYear(),
                default => now()->subMonth(),
            };
            
            $query->where('created_at', '>=', $dateFilter);
        }

        return $query->get();
    }

    public static function getTopItemsByQuantity($limit = 10, $period = 'all')
    {
        $query = SaleItem::query()
            ->select([
                'item_type',
                'item_id',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(total) as total_revenue'),
                DB::raw('COUNT(DISTINCT sale_id) as sale_count')
            ])
            ->groupBy('item_type', 'item_id')
            ->orderByDesc('total_quantity')
            ->limit($limit);

        if ($period !== 'all') {
            $dateFilter = match($period) {
                'today' => now()->startOfDay(),
                'week' => now()->subWeek(),
                'month' => now()->subMonth(),
                'year' => now()->subYear(),
                default => now()->subMonth(),
            };
            
            $query->where('created_at', '>=', $dateFilter);
        }

        return $query->get();
    }

    public static function getSalesSummary($period = 'all')
    {
        $query = SaleItem::query()
            ->select([
                DB::raw('COUNT(DISTINCT sale_id) as total_sales'),
                DB::raw('SUM(quantity) as total_items_sold'),
                DB::raw('SUM(total) as total_revenue'),
                DB::raw('AVG(total) as average_sale_value')
            ]);

        if ($period !== 'all') {
            $dateFilter = match($period) {
                'today' => now()->startOfDay(),
                'week' => now()->subWeek(),
                'month' => now()->subMonth(),
                'year' => now()->subYear(),
                default => now()->subMonth(),
            };
            
            $query->where('created_at', '>=', $dateFilter);
        }

        return $query->first();
    }
}
