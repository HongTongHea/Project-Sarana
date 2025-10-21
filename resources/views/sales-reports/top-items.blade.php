@extends('layouts.app')

@section('title', 'Top Selling Items')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('sales-reports.index') }}">Sales Reports</a></li>
                            <li class="breadcrumb-item active">Top Selling Items</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Top Selling Items</h4>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card rounded-0">
                    <div class="card-body">
                        <form action="{{ route('sales-reports.top.items') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label for="period" class="form-label">Period</label>
                                <select name="period" id="period" class="form-select">
                                    <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Daily</option>
                                    <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                    <option value="all" {{ $period == 'all' ? 'selected' : '' }}>All Time</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="limit" class="form-label">Number of Items</label>
                                <select name="limit" id="limit" class="form-select">
                                    <option value="5" {{ request('limit', 10) == 5 ? 'selected' : '' }}>Top 5</option>
                                    <option value="10" {{ request('limit', 10) == 10 ? 'selected' : '' }}>Top 10
                                    </option>
                                    <option value="20" {{ request('limit', 10) == 20 ? 'selected' : '' }}>Top 20
                                    </option>
                                    <option value="50" {{ request('limit', 10) == 50 ? 'selected' : '' }}>Top 50
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-filter"></i> Apply Filters
                                </button>
                                <a href="{{ route('sales-reports.top.items') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card widget-flat rounded-0">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="fas fa-shopping-basket text-primary widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0">Total Items</h5>
                        <h3 class="mt-3 mb-3">{{ $items->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card widget-flat rounded-0">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="fas fa-boxes text-success widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0">Total Quantity Sold</h5>
                        <h3 class="mt-3 mb-3">{{ number_format($items->sum('total_quantity')) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card widget-flat rounded-0">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="fas fa-money-bill-wave text-info widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0">Total Revenue</h5>
                        <h3 class="mt-3 mb-3">${{ number_format($items->sum('total_revenue'), 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card widget-flat rounded-0">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="fas fa-tag text-warning widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0">Avg. Discount</h5>
                        <h3 class="mt-3 mb-3">{{ number_format($items->avg('average_discount') ?? 0, 1) }}%</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Items Table -->
        <div class="row">
            <div class="col-12">
                <div class="card rounded-0">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="header-title mb-0">Top Selling Items - {{ ucfirst($period) }}</h4>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-download"></i> Export
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" onclick="exportToCSV()">CSV</a>
                                <a class="dropdown-item" href="#" onclick="exportToPDF()">PDF</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-centered table-striped table-hover mb-0" id="topItemsTable">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Item</th>
                                        <th>Type</th>
                                        <th>Category</th>
                                        <th>Quantity Sold</th>
                                        <th>Total Revenue</th>
                                        <th>Avg. Price</th>
                                        <th>Avg. Discount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $index => $item)
                                        <tr>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $index < 3 ? 'primary' : 'secondary' }} rounded-pill">
                                                    #{{ $index + 1 }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        @if ($item->image)
                                                            <img src="{{ $item->image }}" alt="{{ $item->name }}"
                                                                class="avatar-sm rounded">
                                                        @else
                                                            <div class="avatar-sm bg-light rounded">
                                                                <span class="avatar-title bg-primary text-white rounded">
                                                                    {{ substr($item->name, 0, 2) }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        <h6 class="mb-0">{{ $item->name }}</h6>
                                                        <small class="text-muted">SKU: {{ $item->sku }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark text-uppercase">
                                                    {{ app('App\Http\Controllers\SalesReportController')->getItemTypeLabel($item->item_type) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $item->category }}</span>
                                            </td>
                                            <td>
                                                <strong>{{ number_format($item->total_quantity) }}</strong>
                                                <small class="text-muted d-block">units</small>
                                            </td>
                                            <td>
                                                <strong>${{ number_format($item->total_revenue, 2) }}</strong>
                                            </td>
                                            <td>
                                                ${{ number_format($item->average_price, 2) }}
                                                @if ($item->original_average_price > $item->average_price)
                                                    <small class="text-muted d-block text-danger">
                                                        <s>${{ number_format($item->original_average_price, 2) }}</s>
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->average_discount > 0)
                                                    <span class="badge bg-success">
                                                        {{ number_format($item->average_discount, 1) }}%
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">0%</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                                    <h5>No items found</h5>
                                                    <p>No sales data available for the selected period.</p>
                                                    <a href="{{ route('sales-reports.index') }}"
                                                        class="btn btn-primary mt-2">
                                                        Generate Reports First
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        @if ($items->count() > 0)
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title">Revenue Distribution</h4>
                        </div>
                        <div class="card-body">
                            <div id="revenueChart" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title">Quantity vs Revenue</h4>
                        </div>
                        <div class="card-body">
                            <div id="quantityRevenueChart" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <!-- Charting Library -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        // Initialize charts when page loads
        document.addEventListener('DOMContentLoaded', function() {
            @if ($items->count() > 0)
                initializeCharts();
            @endif
        });

        function initializeCharts() {
            // Revenue Distribution Pie Chart
            const revenueChart = new ApexCharts(document.querySelector("#revenueChart"), {
                series: [{!! $items->pluck('total_revenue')->toJson() !!}],
                chart: {
                    type: 'pie',
                    height: 300
                },
                labels: [{!! $items->pluck('name')->map(function ($name) {
                        return strlen($name) > 20 ? name . substring(0, 20) + '...' : $name;
                    })->toJson() !!}],
                colors: ['#727cf5', '#6c757d', '#0acf97', '#fa5c7c', '#ffbc00', '#39afd1', '#e3eaef', '#313a46'],
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return '$' + value.toFixed(2);
                        }
                    }
                }
            });
            revenueChart.render();

            // Quantity vs Revenue Bar Chart
            const quantityRevenueChart = new ApexCharts(document.querySelector("#quantityRevenueChart"), {
                series: [{
                    name: 'Quantity',
                    type: 'column',
                    data: [{!! $items->pluck('total_quantity')->toJson() !!}]
                }, {
                    name: 'Revenue',
                    type: 'line',
                    data: [{!! $items->pluck('total_revenue')->toJson() !!}]
                }],
                chart: {
                    height: 300,
                    type: 'line',
                    stacked: false
                },
                stroke: {
                    width: [0, 3]
                },
                colors: ['#0acf97', '#727cf5'],
                labels: [{!! $items->pluck('name')->map(function ($name) {
                        return strlen($name) > 15 ? name . substring(0, 15) + '...' : $name;
                    })->toJson() !!}],
                xaxis: {
                    type: 'category',
                    labels: {
                        rotate: -45
                    }
                },
                yaxis: [{
                    title: {
                        text: 'Quantity'
                    }
                }, {
                    opposite: true,
                    title: {
                        text: 'Revenue ($)'
                    }
                }],
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function(y, {
                            seriesIndex
                        }) {
                            if (typeof y !== "undefined") {
                                return seriesIndex === 0 ? y.toFixed(0) + ' units' : '$' + y.toFixed(2);
                            }
                            return y;
                        }
                    }
                }
            });
            quantityRevenueChart.render();
        }

        function exportToCSV() {
            // Implement CSV export functionality
            alert('CSV export functionality would be implemented here');
        }

        function exportToPDF() {
            // Implement PDF export functionality
            alert('PDF export functionality would be implemented here');
        }
    </script>

    <style>
        .widget-icon {
            font-size: 24px;
            opacity: 0.7;
        }

        .avatar-sm {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .table tbody tr:hover {
            background-color: rgba(114, 124, 245, 0.05);
        }

        .badge {
            font-size: 0.75em;
        }

        .avatar-sm img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endsection
