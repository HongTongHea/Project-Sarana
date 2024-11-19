<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SalesReport;
use Illuminate\Http\Request;

class SalesReportController extends Controller
{
    // Automatically populate SalesReports table with aggregated data
    public function generateReports()
    {
        // Clear existing reports (optional)
        SalesReport::truncate();

        // Aggregate total sales by product_id and customer_id from the Sales table
        $aggregatedSales = Sale::select('product_id', 'customer_id')
            ->selectRaw('SUM(total_price) as total_sales')
            ->groupBy('product_id', 'customer_id')
            ->get();

        // Save the aggregated data into the SalesReports table
        foreach ($aggregatedSales as $data) {
            SalesReport::updateOrCreate(
                ['product_id' => $data->product_id, 'customer_id' => $data->customer_id],
                ['total_sales' => $data->total_sales]
            );
        }

        return redirect()->route('sales_reports.index')->with('success', 'Sales reports generated successfully.');
    }

    public function index()
    {
        // Fetch data for the view
        $sales = Sale::all();
        $reports = SalesReport::with(['product', 'customer'])->get();
        return view('sales_reports.index', compact('reports' , 'sales'));
    }

    public function show($id)
    {
        $report = SalesReport::with(['product', 'customer'])->find($id);
        if (!$report) {
            return redirect()->route('sales_reports.index')->with('error', 'Sales report not found.');
        }

        return view('sales_reports.show', compact('report'));
    }
}
