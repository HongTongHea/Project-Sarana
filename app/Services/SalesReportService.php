<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\SalesReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesReportService
{
    public function generateDailyReport($date = null)
    {
        if (!$date) {
            $date = Carbon::now();
        }

        $startDate = Carbon::parse($date)->startOfDay();
        $endDate = Carbon::parse($date)->endOfDay();

        return $this->generateReport('daily', $startDate, $endDate);
    }

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

    private function generateReport(string $type, Carbon $startDate, Carbon $endDate)
    {
        // Validate type is one of the allowed ENUM values
        $allowedTypes = ['daily', 'weekly', 'monthly', 'yearly'];
        if (!in_array($type, $allowedTypes)) {
            throw new \Exception("Invalid report type: {$type}");
        }

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

        // Get top products
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

        $totalSales    = round((float) ($salesData->total_sales ?? 0), 2);
        $paidAmount    = round((float) ($salesData->paid_amount ?? 0), 2);
        $totalTax      = round((float) ($salesData->total_tax ?? 0), 2);
        $avgOrderValue = round((float) ($salesData->average_order_value ?? 0), 2);

        $reportData = [
            'daily_breakdown'  => $dailyBreakdown,
            'top_products'     => $topProducts,
            'unique_customers' => (int) ($salesData->unique_customers ?? 0),
            'paid_amount'      => $paidAmount,
            'pending_amount'   => round($totalSales - $paidAmount, 2),
        ];

        try {
            return SalesReport::create([
                'report_type'         => $type,
                'start_date'          => $startDate->format('Y-m-d'),
                'end_date'            => $endDate->format('Y-m-d'),
                'total_orders'        => (int) ($salesData->total_orders ?? 0),
                'total_sales'         => $totalSales,
                'total_tax'           => $totalTax,
                'average_order_value' => $avgOrderValue,
                'report_data'         => $reportData,
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
