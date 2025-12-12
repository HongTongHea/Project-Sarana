<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\SalesReport;
use App\Models\Product;
use App\Models\Accessory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesReportService
{
    public function generateWeeklyReport($startDate = null, $endDate = null)
    {
        if (!$startDate) {
            $startDate = Carbon::now()->startOfWeek();
        }
        if (!$endDate) {
            $endDate = Carbon::now()->endOfWeek();
        }

        return $this->generateReport('weekly', $startDate, $endDate);
    }

    public function generateMonthlyReport($year = null, $month = null)
    {
        if (!$year) $year = Carbon::now()->year;
        if (!$month) $month = Carbon::now()->month;

        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        return $this->generateReport('monthly', $startDate, $endDate);
    }

    public function generateYearlyReport($year = null)
    {
        if (!$year) $year = Carbon::now()->year;

        $startDate = Carbon::create($year, 1, 1)->startOfYear();
        $endDate = Carbon::create($year, 12, 31)->endOfYear();

        return $this->generateReport('yearly', $startDate, $endDate);
    }

    private function generateReport($type, $startDate, $endDate)
    {
        // Check if report already exists
        $existingReport = SalesReport::where('report_type', $type)
            ->where('start_date', $startDate->format('Y-m-d'))
            ->where('end_date', $endDate->format('Y-m-d'))
            ->first();

        if ($existingReport) {
            return $existingReport;
        }

        // Get sales data
        $salesData = Sale::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->select([
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('COALESCE(SUM(total), 0) as total_sales'),
                DB::raw('COALESCE(SUM(tax_amount), 0) as total_tax'),
                DB::raw('COALESCE(AVG(total), 0) as average_order_value'),
                DB::raw('COUNT(DISTINCT customer_id) as unique_customers'),
                DB::raw('COALESCE(SUM(CASE WHEN payment_status = "paid" THEN total ELSE 0 END), 0) as paid_amount'),
            ])
            ->first();

        // Get daily breakdown
        $dailyBreakdown = Sale::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->select([
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as orders_count'),
                DB::raw('COALESCE(SUM(total), 0) as daily_sales'),
            ])
            ->groupBy('date')
            ->get();

        // Get top items (products + accessories)
        $topItems = $this->getTopItems(10, $startDate, $endDate);

        $reportData = [
            'daily_breakdown' => $dailyBreakdown,
            'top_items' => $topItems,
            'unique_customers' => $salesData->unique_customers ?? 0,
            'paid_amount' => $salesData->paid_amount ?? 0,
            'pending_amount' => ($salesData->total_sales ?? 0) - ($salesData->paid_amount ?? 0),
        ];

        try {
            return SalesReport::create([
                'report_type' => $type,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'total_orders' => $salesData->total_orders ?? 0,
                'total_sales' => $salesData->total_sales ?? 0,
                'total_tax' => $salesData->total_tax ?? 0,
                'average_order_value' => $salesData->average_order_value ?? 0,
                'report_data' => $reportData,
            ]);
        } catch (\Exception $e) {
            throw new \Exception("Failed to create report: " . $e->getMessage());
        }
    }

    public function deleteReport($id)
    {
        $report = SalesReport::findOrFail($id);
        $report->delete();

        return true;
    }

    public function getReports($type = null, $limit = 10)
    {
        $query = SalesReport::query();

        if ($type) {
            $query->where('report_type', $type);
        }

        return $query->orderBy('created_at', 'desc')->paginate($limit);
    }

    public function getTopItems($limit = 10, $startDate = null, $endDate = null)
    {
        if (!$startDate) {
            $startDate = Carbon::now()->startOfMonth();
        }
        if (!$endDate) {
            $endDate = Carbon::now()->endOfMonth();
        }

        // Get top items from sale_items table (both products and accessories)
        $topItems = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->whereBetween('sales.created_at', [$startDate, $endDate])
            ->where('sales.status', 'completed')
            ->select([
                'sale_items.item_type',
                'sale_items.item_id',
                DB::raw('SUM(sale_items.quantity) as total_quantity'),
                DB::raw('SUM(sale_items.total) as total_revenue'),
            ])
            ->groupBy('sale_items.item_type', 'sale_items.item_id')
            ->orderByDesc('total_quantity')
            ->limit($limit)
            ->get();

        // Process items to get details and images
        $processedItems = [];
        
        foreach ($topItems as $item) {
            $itemDetails = null;
            $imageUrl = null;
            $itemName = 'Unknown Item';
            $itemTypeFormatted = ucfirst($item->item_type);
            
            // Get item details based on type
            if ($item->item_type === 'product' && class_exists(Product::class)) {
                $product = Product::find($item->item_id);
                if ($product) {
                    $itemDetails = $product;
                    $itemName = $product->name;
                    $imageUrl = $product->image_url ?? 
                               ($product->image ? asset('storage/' . $product->image) : 
                               asset('images/default-product.png'));
                }
            } elseif ($item->item_type === 'accessory' && class_exists(Accessory::class)) {
                $accessory = Accessory::find($item->item_id);
                if ($accessory) {
                    $itemDetails = $accessory;
                    $itemName = $accessory->name;
                    $imageUrl = $accessory->image_url ?? 
                               ($accessory->image ? asset('storage/' . $accessory->image) : 
                               asset('images/default-accessory.png'));
                }
            }
            
            if ($itemDetails) {
                $processedItems[] = [
                    'type' => $item->item_type,
                    'type_formatted' => $itemTypeFormatted,
                    'id' => $item->item_id,
                    'name' => $itemName,
                    'image_url' => $imageUrl,
                    'total_quantity' => $item->total_quantity,
                    'total_revenue' => $item->total_revenue,
                    'average_price' => $item->total_quantity > 0 ? $item->total_revenue / $item->total_quantity : 0,
                    'item' => $itemDetails
                ];
            }
        }

        return $processedItems;
    }

    public function getTopItemsReport($startDate = null, $endDate = null, $limit = 10)
    {
        if (!$startDate) {
            $startDate = Carbon::now()->subMonth()->startOfMonth();
        }
        if (!$endDate) {
            $endDate = Carbon::now()->endOfMonth();
        }

        $topItems = $this->getTopItems($limit, $startDate, $endDate);

        // Get sales summary for the period
        $salesSummary = Sale::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->select([
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('COALESCE(SUM(total), 0) as total_sales'),
                DB::raw('COALESCE(COUNT(DISTINCT customer_id), 0) as unique_customers'),
            ])
            ->first();

        return [
            'top_items' => $topItems,
            'sales_summary' => $salesSummary,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'period_formatted' => $startDate->format('M d, Y') . ' to ' . $endDate->format('M d, Y')
        ];
    }
}