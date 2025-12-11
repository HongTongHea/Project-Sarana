@extends('layouts.app')

@section('title', 'Top Selling Items')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line"></i> Top Selling Items
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('sales-reports.top.items') }}" class="mb-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                            value="{{ request('start_date') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                            value="{{ request('end_date') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="limit">Number of Items</label>
                                        <select class="form-control" id="limit" name="limit">
                                            <option value="5" {{ request('limit', 10) == 5 ? 'selected' : '' }}>Top 5
                                            </option>
                                            <option value="10" {{ request('limit', 10) == 10 ? 'selected' : '' }}>Top 10
                                            </option>
                                            <option value="15" {{ request('limit', 10) == 15 ? 'selected' : '' }}>Top 15
                                            </option>
                                            <option value="20" {{ request('limit', 10) == 20 ? 'selected' : '' }}>Top 20
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <div class="form-group w-100">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-filter"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if (count($topItems) > 0)
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-list-ol"></i> Top Items List
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Item Name</th>
                                            <th>Type</th>
                                            <th>Quantity Sold</th>
                                            <th>Total Revenue</th>
                                            <th>Average Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topItems as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    @if ($item['image_url'])
                                                        <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}"
                                                            class="img-thumbnail"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-secondary d-flex align-items-center justify-content-center"
                                                            style="width: 50px; height: 50px;">
                                                            <i class="fas fa-image text-white"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>{{ $item['name'] }}</strong>
                                                    @if ($item['type'] == 'product')
                                                        <span class="badge badge-primary ml-2">Product</span>
                                                    @else
                                                        <span class="badge badge-info ml-2">Accessory</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item['type'] == 'product')
                                                        <span class="badge badge-primary">Product</span>
                                                    @else
                                                        <span class="badge badge-info">Accessory</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge badge-success" style="font-size: 1em;">
                                                        {{ number_format($item['total_quantity']) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-success font-weight-bold">
                                                        ${{ number_format($item['total_revenue'], 2) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    ${{ number_format($item['total_revenue'] / max($item['total_quantity'], 1), 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie"></i> Revenue Distribution
                            </h3>
                        </div>
                        <div class="card-body">
                            <div style="height: 300px;">
                                <canvas id="revenueChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar"></i> Quantity Sold
                            </h3>
                        </div>
                        <div class="card-body">
                            <div style="height: 300px;">
                                <canvas id="quantityChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-chart-line fa-4x text-muted mb-3"></i>
                            <h4>No sales data found for the selected period</h4>
                            <p class="text-muted">Try selecting a different date range</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    @if (count($topItems) > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Revenue Chart
                const revenueCtx = document.getElementById('revenueChart').getContext('2d');
                const revenueLabels = @json(array_column($topItems, 'name'));
                const revenueData = @json(array_column($topItems, 'total_revenue'));

                const revenueChart = new Chart(revenueCtx, {
                    type: 'pie',
                    data: {
                        labels: revenueLabels,
                        datasets: [{
                            data: revenueData,
                            backgroundColor: [
                                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                                '#9966FF', '#FF9F40', '#C9CBCF', '#FF6384',
                                '#36A2EB', '#FFCE56'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right'
                            }
                        }
                    }
                });

                // Quantity Chart
                const quantityCtx = document.getElementById('quantityChart').getContext('2d');
                const quantityData = @json(array_column($topItems, 'total_quantity'));

                const quantityChart = new Chart(quantityCtx, {
                    type: 'bar',
                    data: {
                        labels: revenueLabels,
                        datasets: [{
                            label: 'Quantity Sold',
                            data: quantityData,
                            backgroundColor: '#36A2EB',
                            borderColor: '#36A2EB',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value.toLocaleString();
                                    }
                                }
                            },
                            x: {
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 45
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endif
@endpush

@push('styles')
    <style>
        .img-thumbnail {
            border-radius: 4px;
        }

        .badge {
            font-size: 0.85em;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }
    </style>
@endpush
