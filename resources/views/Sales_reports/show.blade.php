@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1>Sales Report for Product: {{ $report->product->name }}</h1>

            <div>
                <p><strong>Report ID:</strong> {{ $report->id }}</p>
                <p><strong>Total Sales:</strong> ${{ number_format($report->total_sales, 2) }}</p>
                <p><strong>Last Updated:</strong> {{ $report->updated_at->format('Y-m-d H:i') }}</p>
            </div>

            <a href="{{ route('sales_reports.index') }}" class="btn btn-secondary">Back to Reports</a>
        </div>
    </div>
@endsection
