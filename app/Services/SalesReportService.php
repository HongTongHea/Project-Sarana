<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\SalesReport;
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

        // Get sales data - fix the query to handle null values
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

        // Get top products - UPDATED: Changed from order_items to sale_items
        $topProducts = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->whereBetween('sales.created_at', [$startDate, $endDate])
            ->where('sales.status', 'completed')
            ->select([
                'sale_items.item_type',
                'sale_items.item_id',
                DB::raw('COALESCE(SUM(sale_items.quantity), 0) as total_quantity'),
                DB::raw('COALESCE(SUM(sale_items.total), 0) as total_revenue'),
            ])
            ->groupBy('sale_items.item_type', 'sale_items.item_id')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get();

        $reportData = [
            'daily_breakdown' => $dailyBreakdown,
            'top_products' => $topProducts,
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

}
