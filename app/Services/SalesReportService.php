<?php

namespace App\Services;

use App\Models\Order;
use App\Models\SalesReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesReportService
{
    public function generateAndStoreReport(string $period, ?string $startDate = null, ?string $endDate = null)
    {
        $reportData = $this->getSalesData($period, $startDate, $endDate);

        return $this->storeReport($reportData, $period);
    }

    public function getSalesData(string $period, ?string $startDate = null, ?string $endDate = null)
    {
        $query = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total_orders'),
            DB::raw('SUM(subtotal) as total_subtotal'),
            DB::raw('SUM(tax_amount) as total_tax_amount'),
            DB::raw('SUM(discount_amount) as total_discount_amount'),
            DB::raw('SUM(total) as total_revenue'),
            DB::raw('AVG(total) as average_order_value')
        )
            ->where('status', 'completed')
            ->groupBy('date')
            ->orderBy('date');

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        return $query->get();
    }

    protected function storeReport($data, string $period)
    {
        $groupedData = $this->groupByPeriod($data, $period);
        $storedReports = [];

        foreach ($groupedData as $periodData) {
            $existingReport = SalesReport::where('period_type', $period)
                ->where('period_value', $periodData['period_value'])
                ->first();

            if ($existingReport) {
                $existingReport->update($periodData);
                $storedReports[] = $existingReport;
            } else {
                $storedReports[] = SalesReport::create($periodData);
            }
        }

        return $storedReports;
    }

    protected function groupByPeriod($data, string $period)
    {
        $grouped = [];

        foreach ($data as $item) {
            $date = Carbon::parse($item->date);

            switch ($period) {
                case 'weekly':
                    $periodValue = $date->year . '-W' . $date->week;
                    $startDate = $date->copy()->startOfWeek();
                    $endDate = $date->copy()->endOfWeek();
                    break;

                case 'monthly':
                    $periodValue = $date->format('Y-m');
                    $startDate = $date->copy()->startOfMonth();
                    $endDate = $date->copy()->endOfMonth();
                    break;

                case 'yearly':
                    $periodValue = $date->year;
                    $startDate = $date->copy()->startOfYear();
                    $endDate = $date->copy()->endOfYear();
                    break;

                default:
                    $periodValue = $date->format('Y-m-d');
                    $startDate = $date->copy()->startOfDay();
                    $endDate = $date->copy()->endOfDay();
                    break;
            }

            if (!isset($grouped[$periodValue])) {
                $grouped[$periodValue] = [
                    'period_type' => $period,
                    'period_value' => $periodValue,
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d'),
                    'total_orders' => 0,
                    'total_subtotal' => 0,
                    'total_tax_amount' => 0,
                    'total_discount_amount' => 0,
                    'total_revenue' => 0,
                    'average_order_value' => 0
                ];
            }

            $grouped[$periodValue]['total_orders'] += $item->total_orders;
            $grouped[$periodValue]['total_subtotal'] += $item->total_subtotal;
            $grouped[$periodValue]['total_tax_amount'] += $item->total_tax_amount;
            $grouped[$periodValue]['total_discount_amount'] += $item->total_discount_amount;
            $grouped[$periodValue]['total_revenue'] += $item->total_revenue;
        }

        foreach ($grouped as &$periodData) {
            if ($periodData['total_orders'] > 0) {
                $periodData['average_order_value'] = $periodData['total_revenue'] / $periodData['total_orders'];
            }
        }

        return array_values($grouped);
    }

    public function generateWeeklyReports(?string $year = null)
    {
        $year = $year ?? date('Y');
        $startDate = $year . '-01-01';
        $endDate = $year . '-12-31';

        return $this->generateAndStoreReport('weekly', $startDate, $endDate);
    }

    public function generateMonthlyReports(?string $year = null)
    {
        $year = $year ?? date('Y');
        $startDate = $year . '-01-01';
        $endDate = $year . '-12-31';

        return $this->generateAndStoreReport('monthly', $startDate, $endDate);
    }

    public function generateYearlyReports(?int $yearsBack = 5)
    {
        $startDate = Carbon::now()->subYears($yearsBack)->startOfYear()->format('Y-m-d');
        $endDate = Carbon::now()->endOfYear()->format('Y-m-d');

        return $this->generateAndStoreReport('yearly', $startDate, $endDate);
    }

    public function getStoredReports(string $period, ?string $startDate = null, ?string $endDate = null)
    {
        $query = SalesReport::where('period_type', $period)
            ->orderBy('period_value');

        if ($startDate) {
            $query->where('start_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('end_date', '<=', $endDate);
        }

        return $query->get();
    }

    public function getTopSellingItems(string $period, int $limit = 10)
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select(
                'order_items.item_type',
                'order_items.item_id',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.total) as total_revenue')
            )
            ->where('orders.status', 'completed')
            ->groupBy('order_items.item_type', 'order_items.item_id')
            ->orderBy('total_revenue', 'desc')
            ->limit($limit)
            ->get();
    }

    public function regenerateAllReports()
    {
        SalesReport::truncate();

        $currentYear = date('Y');

        for ($year = $currentYear - 2; $year <= $currentYear; $year++) {
            $this->generateYearlyReports($year);
            $this->generateMonthlyReports($year);
            $this->generateWeeklyReports($year);
        }

        return SalesReport::count();
    }
}
