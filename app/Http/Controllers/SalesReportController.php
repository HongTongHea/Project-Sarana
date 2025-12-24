<?php

namespace App\Http\Controllers;

use App\Services\SalesReportService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SalesReportController extends Controller
{
    protected $salesReportService;

    public function __construct(SalesReportService $salesReportService)
    {
        $this->salesReportService = $salesReportService;
    }

    public function index(Request $request)
    {
        $type = $request->get('type') ?? $request->get('report_type');
        $reports = $this->salesReportService->getReports($type);

        // If AJAX request, return JSON
        if ($request->ajax()) {
            // Transform reports data for JSON response
            $reportsData = $reports->map(function ($report) {
                return [
                    'id' => $report->id,
                    'report_type' => $report->report_type,
                    'start_date' => $report->start_date->setTimezone('Asia/Phnom_Penh')->format('M d, Y h:i A'),
                    'end_date' => $report->end_date->setTimezone('Asia/Phnom_Penh')->format('M d, Y h:i A'),
                    'total_orders' => $report->total_orders,
                    'total_sales' => $report->total_sales,
                    'average_order_value' => $report->average_order_value,
                    'created_at' => $report->created_at->setTimezone('Asia/Phnom_Penh')->format('M d, Y h:i A'),
                    'can_delete' => Auth::check() && Auth::user()->role === 'admin'
                ];
            });

            // Generate modals HTML
            $modalsHtml = '';
            foreach ($reports as $report) {
                $modalsHtml .= view('sales-reports.show', ['report' => $report])->render();
                $modalsHtml .= view('sales-reports.delete', ['report' => $report])->render();
            }

            return response()->json([
                'reports' => [
                    'data' => $reportsData,
                    'current_page' => $reports->currentPage(),
                    'last_page' => $reports->lastPage(),
                    'per_page' => $reports->perPage(),
                    'total' => $reports->total(),
                    'from' => $reports->firstItem(),
                    'to' => $reports->lastItem()
                ],
                'modals' => $modalsHtml
            ]);
        }

        return view('sales-reports.index', compact('reports'));
    }

    public function generateWeekly(Request $request)
    {
        try {
            // Your logic to generate weekly report
            $report = $this->createWeeklyReport();

            return response()->json([
                'success' => true,
                'message' => 'Weekly report generated successfully!',
                'report' => $report
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate weekly report: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generateWeeklyReport(Request $request): JsonResponse
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        Log::info('Generate Weekly Report Request:', $request->all());

        try {
            $report = $this->salesReportService->generateWeeklyReport(
                $request->start_date ? Carbon::parse($request->start_date) : null,
                $request->end_date ? Carbon::parse($request->end_date) : null
            );

            Log::info('Weekly Report Generated:', ['id' => $report->id]);

            return response()->json([
                'success' => true,
                'message' => 'Weekly report generated successfully',
                'report' => $report
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to generate weekly report:', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate weekly report: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generateMonthlyReport(Request $request): JsonResponse
    {
        $request->validate([
            'year' => 'nullable|integer|min:2020|max:2030',
            'month' => 'nullable|integer|min:1|max:12',
        ]);

        try {
            $report = $this->salesReportService->generateMonthlyReport(
                $request->year,
                $request->month
            );

            return response()->json([
                'success' => true,
                'message' => 'Monthly report generated successfully',
                'report' => $report
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate monthly report: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generateYearlyReport(Request $request): JsonResponse
    {
        $request->validate([
            'year' => 'nullable|integer|min:2020|max:2030',
        ]);

        try {
            $report = $this->salesReportService->generateYearlyReport($request->year);

            return response()->json([
                'success' => true,
                'message' => 'Yearly report generated successfully',
                'report' => $report
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate yearly report: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $report = \App\Models\SalesReport::findOrFail($id);

        return view('sales-reports.show', compact('report'));
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->salesReportService->deleteReport($id);

            return response()->json([
                'success' => true,
                'message' => 'Report deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete report: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getReportData($id): JsonResponse
    {
        $report = \App\Models\SalesReport::findOrFail($id);

        return response()->json([
            'success' => true,
            'report' => $report
        ]);
    }
}