@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row ">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
                    {{-- <h4 class="mb-0 fw-semibold text-uppercase">Sales Analysis</h4> --}}
                </div>
                <!-- Enhanced Filter Card -->
                <div class="card shadow-sm rounded-0">
                    <div class="card-body">
                        <form id="filterForm" class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label for="period" class="form-label fw-bold">
                                    <i class="fas fa-calendar-alt"></i> Filter Period
                                </label>
                                <select name="period" id="period" class="form-select form-control">
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
                                <select name="item_type" id="item_type" class="form-select form-control">
                                    <option value="all" {{ request('item_type') == 'all' ? 'selected' : '' }}>All Types
                                    </option>
                                    <option value="product" {{ request('item_type') == 'product' ? 'selected' : '' }}>
                                        Products Only
                                    </option>
                                    <option value="accessory" {{ request('item_type') == 'accessory' ? 'selected' : '' }}>
                                        Accessories Only
                                    </option>
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
                                    <button type="button" id="resetBtn" class="btn btn-outline-secondary w-100">
                                        <i class="fas fa-redo"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div id="summaryCards" class="row">
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
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
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
                                <div class="icon-big text-center icon-success bubble-shadow-small">
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
                                <div class="icon-big text-center icon-success bubble-shadow-small">
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
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-semibold text-uppercase">Top Sale Items</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 fw-semibold">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Top Sale Items</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="DataTable" class="table mt-3 table-border table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>no</th>
                                <th>Image</th>
                                <th>Item Name</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Revenue</th>
                                <th>Sales Out</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
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
                                    <td>
                                        @if ($item->item_type == 'App\Models\Product')
                                            <span class="badge bg-success">Product</span>
                                        @elseif($item->item_type == 'App\Models\Accessory')
                                            <span class="badge bg-info">Accessory</span>
                                        @else
                                            <span class="badge bg-secondary">Other</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($item->total_quantity) }}</td>
                                    <td class="fw-bold text-primary">
                                        ${{ number_format($item->total_revenue, 2) }}</td>
                                    <td>{{ number_format($item->sale_count) }}</td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Auto-submit on select change
            $('#period, #item_type').on('change', function() {
                $('#filterForm').submit();
            });

            // Handle form submission
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                loadData();
            });

            // Handle reset button
            $('#resetBtn').on('click', function() {
                $('#period').val('all');
                $('#item_type').val('all');
                $('#min_revenue').val('');
                loadData();
            });

            function loadData() {
                const formData = {
                    period: $('#period').val(),
                    item_type: $('#item_type').val(),
                    min_revenue: $('#min_revenue').val()
                };

                // Show loading overlay
                $('#loadingOverlay').css('display', 'flex');

                $.ajax({
                    url: "{{ route('sale-analysis.index') }}",
                    type: 'GET',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        updateSummaryCards(response.summary);
                        updateTable(response.topByRevenue);

                        // Update URL without reload
                        const url = new URL(window.location);
                        Object.keys(formData).forEach(key => {
                            if (formData[key]) {
                                url.searchParams.set(key, formData[key]);
                            } else {
                                url.searchParams.delete(key);
                            }
                        });
                        window.history.pushState({}, '', url);
                    },
                    error: function(xhr) {
                        console.error('Error loading data:', xhr);
                        alert('An error occurred while loading data. Please try again.');
                    }
                });

            }

            function updateSummaryCards(summary) {
                const cards = [{
                        selector: '.col-lg-3:eq(0) .card-title',
                        value: '$' + formatNumber(summary.total_revenue, 2)
                    },
                    {
                        selector: '.col-lg-3:eq(1) .card-title',
                        value: formatNumber(summary.total_items_sold)
                    },
                    {
                        selector: '.col-lg-3:eq(2) .card-title',
                        value: formatNumber(summary.total_sales)
                    },
                    {
                        selector: '.col-lg-3:eq(3) .card-title',
                        value: '$' + formatNumber(summary.average_sale_value, 2)
                    }
                ];

                cards.forEach(card => {
                    $(card.selector).text(card.value);
                });
            }

            function updateTable(items) {
                const tbody = $('#tableBody');
                tbody.empty();

                if (items.length === 0) {
                    tbody.append('<tr><td colspan="7" class="text-center">No data available</td></tr>');
                    return;
                }

                items.forEach((item, index) => {
                    const imageUrl = item.details && item.details.picture_url ?
                        "{{ asset('storage/') }}/" + item.details.picture_url :
                        "{{ asset('assets/img/image.png') }}";

                    const itemName = item.details && item.details.name ?
                        item.details.name :
                        'Item #' + item.item_id;

                    let badgeClass = 'bg-secondary';
                    let badgeText = 'Other';
                    if (item.item_type === 'App\\Models\\Product') {
                        badgeClass = 'bg-success';
                        badgeText = 'Product';
                    } else if (item.item_type === 'App\\Models\\Accessory') {
                        badgeClass = 'bg-info';
                        badgeText = 'Accessory';
                    }

                    const row = `
                        <tr>
                            <td class="fw-bold">${index + 1}</td>
                            <td>
                                <img src="${imageUrl}" alt="${itemName}" width="70" height="70"
                                    style="object-fit: cover; object-position: center;">
                            </td>
                            <td>
                                <div class="fw-semibold">${itemName}</div>
                            </td>
                            <td>
                                <span class="badge ${badgeClass}">${badgeText}</span>
                            </td>
                            <td>${formatNumber(item.total_quantity)}</td>
                            <td class="fw-bold text-primary">$${formatNumber(item.total_revenue, 2)}</td>
                            <td>${formatNumber(item.sale_count)}</td>
                        </tr>
                    `;
                    tbody.append(row);
                });
            }

            function formatNumber(num, decimals = 0) {
                if (!num) return decimals > 0 ? '0.' + '0'.repeat(decimals) : '0';
                return Number(num).toLocaleString('en-US', {
                    minimumFractionDigits: decimals,
                    maximumFractionDigits: decimals
                });
            }
        });
    </script>
@endsection
