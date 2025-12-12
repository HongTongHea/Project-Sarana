@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row ">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
                    <h4 class="mb-0 fw-semibold text-uppercase">Sales Analysis Dashboard</h4>
                </div>

                <!-- Enhanced Filter Card -->
                <div class="card shadow-sm rounded-0">
                    <div class="card-body">
                        <form method="GET" action="{{ route('sale-analysis.index') }}" class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label for="period" class="form-label fw-bold">
                                    <i class="fas fa-calendar-alt"></i> Filter Period
                                </label>
                                <select name="period" id="period" class="form-select form-control"
                                    onchange="this.form.submit()">
                                    <option value="all" {{ $period == 'all' ? 'selected' : '' }}>All Time</option>
                                    <option value="today" {{ $period == 'today' ? 'selected' : '' }}>Today</option>
                                    <option value="week" {{ $period == 'week' ? 'selected' : '' }}>Last 7 Days</option>
                                    <option value="month" {{ $period == 'month' ? 'selected' : '' }}>Last 30 Days</option>
                                    <option value="year" {{ $period == 'year' ? 'selected' : '' }}>Last Year</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="item_type" class="form-label fw-bold">
                                    <i class="fas fa-filter"></i> Item Type
                                </label>
                                <select name="item_type" id="item_type" class="form-select form-control"
                                    onchange="this.form.submit()">
                                    <option value="all" {{ request('item_type') == 'all' ? 'selected' : '' }}>All Types
                                    </option>
                                    <option value="product" {{ request('item_type') == 'product' ? 'selected' : '' }}>
                                        Products Only</option>
                                    <option value="accessory" {{ request('item_type') == 'accessory' ? 'selected' : '' }}>
                                        Accessories Only</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="min_revenue" class="form-label fw-bold">
                                    <i class="fas fa-dollar-sign"></i> Min Revenue
                                </label>
                                <input type="number" name="min_revenue" id="min_revenue" class="form-control"
                                    placeholder="0.00" step="0.01" value="{{ request('min_revenue') }}">
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-search"></i> Apply Filters
                                    </button>
                                    <a href="{{ route('sale-analysis.index') }}" class="btn btn-outline-secondary w-100">
                                        <i class="fas fa-redo"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Revenue</p>
                                    <h4 class="card-title">${{ number_format($summary->total_revenue ?? 0, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-box"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Items Sold</p>
                                    <h4 class="card-title">{{ number_format($summary->total_items_sold ?? 0) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Sales</p>
                                    <h4 class="card-title">{{ number_format($summary->total_sales ?? 0) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Average Sale</p>
                                    <h4 class="card-title">${{ number_format($summary->average_sale_value ?? 0, 2) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Items Tables -->

        <div class="card shadow-sm rounded-0">
            <div class="card-header">
                <h4 class="mb-0 fw-semibold text-uppercase">Top Sale Items</h4>
            </div>
            <div class="card-body p-0">
                <a href="{{ route('sale-analysis.report') }}?sort_by=revenue&period={{ $period }}"
                    class="btn btn-primary btn-sm mb-3 ml-3 mt-3">
                    <i class="fas fa-chart-bar"></i> View Full Report
                </a>
                <div class="table-responsive">
                    <table id="DataTable" class="table table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center" style="width: 50px;">no</th>
                                <th>Image</th>
                                <th>Item Name</th>
                                <th class="text-center" style="width: 100px;">Type</th>
                                <th class="text-end" style="width: 100px;">Quantity</th>
                                <th class="text-end" style="width: 120px;">Revenue</th>
                                <th class="text-end" style="width: 100px;">Sales Out</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($topByRevenue as $index => $item)
                                <tr>
                                    <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                    <td>
                                        @if ($item->details && $item->details->picture_url)
                                            <img src="{{ asset('storage/' . $item->details->picture_url) }}"
                                                alt="{{ $item->details->name }}" width="70" height="70"
                                                style="object-fit: cover; object-position: center;">
                                        @else
                                            <img src="{{ asset('assets/img/image.png') }}" width="70" height="70"
                                                style="object-fit: cover;">
                                        @endif
                                    <td>
                                        <div class="fw-semibold">
                                            @if ($item->details)
                                                {{ $item->details->name ?? 'N/A' }}
                                            @else
                                                Item #{{ $item->item_id }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if ($item->item_type == 'App\Models\Product')
                                            <span class="badge bg-success">Product</span>
                                        @elseif($item->item_type == 'App\Models\Accessory')
                                            <span class="badge bg-info">Accessory</span>
                                        @else
                                            <span class="badge bg-secondary">Other</span>
                                        @endif
                                    </td>
                                    <td class="text-end">{{ number_format($item->total_quantity) }}</td>
                                    <td class="text-end fw-bold text-primary">
                                        ${{ number_format($item->total_revenue, 2) }}</td>
                                    <td class="text-end">{{ number_format($item->sale_count) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p class="mb-0">No data available for this period</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border: none;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .table thead th {
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tbody tr {
            transition: background-color 0.2s;
        }

        .table tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .badge {
            font-weight: 500;
            padding: 0.375rem 0.75rem;
        }

        /* .card-header {
                                                                                                                                                                                                                                                                                                border-bottom: none;
                                                                                                                                                                                                                                                                                                padding: 1rem 1.25rem;
                                                                                                                                                                                                                                                                                            } */

        .card-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        @media print {

            .btn,
            .card-footer {
                display: none !important;
            }
        }
    </style>
@endsection
