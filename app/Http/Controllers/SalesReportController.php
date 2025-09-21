<?php

namespace App\Http\Controllers;

use App\Services\SalesReportService;
use Illuminate\Http\Request;

class SalesReportController extends Controller
{
    protected $salesReportService;

    public function __construct(SalesReportService $salesReportService)
    {
        $this->salesReportService = $salesReportService;
    }

    public function index(Request $request)
    {
        $period = $request->get('period', 'monthly');
        $year = $request->get('year', date('Y'));
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $reports = $this->salesReportService->getStoredReports($period, $startDate, $endDate);

        return view('sales-reports.index', [
            'reports' => $reports,
            'period' => $period,
            'year' => $year,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }

    public function generate(Request $request)
    {
        $request->validate([
            'period' => 'required|in:daily,weekly,monthly,yearly',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ]);

        $report = $this->salesReportService->generateAndStoreReport(
            $request->period,
            $request->start_date,
            $request->end_date
        );

        return redirect()->route('sales-reports.index')
            ->with('success', 'Report generated successfully!')
            ->withInput();
    }

    public function generateWeekly(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $this->salesReportService->generateWeeklyReports($year);

        return redirect()->route('sales-reports.index', ['period' => 'weekly', 'year' => $year])
            ->with('success', 'Weekly reports generated successfully!');
    }

    public function generateMonthly(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $this->salesReportService->generateMonthlyReports($year);

        return redirect()->route('sales-reports.index', ['period' => 'monthly', 'year' => $year])
            ->with('success', 'Monthly reports generated successfully!');
    }

    public function generateYearly(Request $request)
    {
        $yearsBack = $request->get('years_back', 5);
        $this->salesReportService->generateYearlyReports($yearsBack);

        return redirect()->route('sales-reports.index', ['period' => 'yearly'])
            ->with('success', 'Yearly reports generated successfully!');
    }

    public function topSellingItems(Request $request)
    {
        $period = $request->get('period', 'monthly');
        $limit = $request->get('limit', 10);
        $items = $this->salesReportService->getTopSellingItems($period, $limit);

        return view('sales-reports.top-items', [
            'items' => $items,
            'period' => $period
        ]);
    }

    public function regenerateAll()
    {
        $count = $this->salesReportService->regenerateAllReports();

        return redirect()->route('sales-reports.index')
            ->with('success', "All reports regenerated successfully! Total: {$count} reports");
    }

    public function create()
    {
        return view('sales-reports.create');
    }
}
