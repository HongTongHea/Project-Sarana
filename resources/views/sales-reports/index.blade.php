@extends('layouts.app')

@section('title', 'AngkorTech Computer | Sales Reports')

@section('content')
    <div class="container-fluid mt-3">
        <div class="card rounded-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-semibold text-uppercase">Sales Reports</h4>

            </div>

            <div class="card-body">

                <div class="row p-2">
                    <div class="col-md-6">
                        <div class="d-flex gap-2 flex-wrap">

                            <button type="button" class="btn btn-primary mb-3 btn-sm" data-bs-toggle="modal"
                                data-bs-target="#createModal">
                                <i class="bi bi-file-earmark-plus"></i> Custom Report
                            </button>

                            <form action="{{ route('sales-reports.generate.weekly') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="year" value="{{ $year }}">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="bi bi-calendar-week"></i> Report Weekly
                                </button>
                            </form>

                            <form action="{{ route('sales-reports.generate.monthly') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="year" value="{{ $year }}">
                                <button type="submit" class="btn btn-info btn-sm">
                                    <i class="bi bi-calendar-month"></i> Report Monthly
                                </button>
                            </form>

                            <form action="{{ route('sales-reports.generate.yearly') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="years_back" value="3">
                                <button type="submit" class="btn btn-warning text-white btn-sm">
                                    <i class="bi bi-calendar3"></i> Report Yearly
                                </button>
                            </form>

                            <form action="{{ route('sales-reports.regenerate.all') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-file-earmark-bar-graph"></i> Report All
                                </button>
                            </form>

                            
                        </div>
                        <a href="{{ route('sales-reports.top.items') }}" class="btn btn-info btn-sm mb-3">
                                <i class="fas fa-chart-line"></i> View Top Selling Items
                            </a>
                    </div>

                    <div class="col-md-6">
                        <form method="GET" action="{{ route('sales-reports.index') }}" class="mb-4">
                            <div class="d-flex gap-2">
                                <select name="period" class="form-select form-select-sm">
                                    <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Daily</option>
                                    <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly
                                    </option>
                                    <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>

                                <input type="number" name="year" class=" form-control form-control-sm"
                                    placeholder="Year" value="{{ $year }}">

                                <button type="submit" class="btn btn-primary btn-sm">Filter</button>

                            </div>
                        </form>
                    </div>
                </div>
                @if ($reports->count() > 0)
                    <div class="table-responsive">
                        <table id="DataTable" class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>
                                        @if ($period === 'daily')
                                            Date
                                        @elseif ($period === 'weekly')
                                            Weekly
                                        @elseif ($period === 'monthly')
                                            Monthly
                                        @elseif ($period === 'yearly')
                                            Year
                                        @else
                                            Period
                                        @endif
                                    </th>
                                    <th>Orders</th>
                                    <th>Subtotal</th>
                                    <th>Tax</th>
                                    <th>Discount</th>
                                    <th>Revenue</th>
                                    <th>Avg Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $report)
                                    <tr>
                                        <td>
                                            @if ($period === 'daily')
                                                {{ 'Week ' . \Carbon\Carbon::parse($report->period_value)->weekOfMonth . ' of ' . \Carbon\Carbon::parse($report->period_value)->format('F Y') }}
                                            @elseif ($period === 'weekly')
                                                {{ $report->period_value }} of {{ $year }}
                                            @elseif ($period === 'monthly')
                                                {{ \Carbon\Carbon::createFromFormat('Y-m', $report->period_value)->format('F Y') }}
                                            @elseif ($period === 'yearly')
                                                {{ $report->period_value }}
                                            @endif
                                        </td>

                                        <td>{{ $report->total_orders }}</td>
                                        <td>${{ number_format($report->total_subtotal, 2) }}</td>
                                        <td>${{ number_format($report->total_tax_amount, 2) }}</td>
                                        <td>${{ number_format($report->total_discount_amount, 2) }}</td>
                                        <td class="fw-bold text-success">${{ number_format($report->total_revenue, 2) }}
                                        </td>
                                        <td>${{ number_format($report->average_order_value, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center">
                        No sales reports found. Generate some reports first.
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('sales-reports.create')
@endsection
