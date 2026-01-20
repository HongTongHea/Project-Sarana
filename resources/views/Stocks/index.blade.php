@extends('layouts.app')

@section('title', 'AngkorTech Computer | Current Stock Levels')

@section('content')
    <div class="container-fluid mt-3">
        <div class="card rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-semibold text-uppercase">Stocks</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="DataTable" class="table table-border mt-3 table-hover ">
                        <thead class="thead-dark">
                            <tr>
                                <th>Type</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Current Stock</th>
                                <th>Purchases</th>
                                <th>Sales</th>
                                <th>Net Change</th>
                                <th>Last Updated</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach ($currentStocks as $index => $stock)
                                <tr>
                                    <td>{{ class_basename($stock['stockable_type']) }}</td>
                                    <td>
                                        @if ($stock['stockable']->picture_url ?? false)
                                            <img src="{{ asset('storage/' . $stock['stockable']->picture_url) }}"
                                                alt="{{ $stock['stockable']->name }}" width="70" height="70"
                                                style="object-fit: cover; object-position: center;">
                                        @else
                                            <img src="{{ asset('assets/img/image.png') }}" width="70" height="70"
                                                style="object-fit: cover;">
                                        @endif
                                    </td>
                                    <td>{{ $stock['stockable']->name ?? 'N/A' }}</td>
                                    <td
                                        class="{{ $stock['current_quantity'] > 0 ? 'text-success fw-bold' : 'text-danger fw-bold' }}">
                                        <i
                                            class="fas {{ $stock['current_quantity'] > 0 ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                        {{ $stock['current_quantity'] > 0 ? $stock['current_quantity'] : 'Out of stock' }}
                                    </td>
                                    <td class="text-success">
                                        <i class="fas fa-arrow-up me-1"></i>+{{ $stock['total_purchases'] }}
                                    </td>
                                    <td class="text-danger">
                                        <i class="fas fa-arrow-down me-1"></i>-{{ $stock['total_sales'] }}
                                    </td>
                                    <td>
                                        @if ($stock['net_change'] > 0)
                                            <span class="text-success fw-bold">
                                                <i class="fas fa-arrow-up me-1"></i>+{{ $stock['net_change'] }}
                                            </span>
                                        @elseif ($stock['net_change'] < 0)
                                            <span class="text-danger fw-bold">
                                                <i class="fas fa-arrow-down me-1"></i>{{ $stock['net_change'] }}
                                            </span>
                                        @else
                                            <span class="text-secondary">
                                                <i class="fas fa-equals me-1"></i>0
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $stock['last_updated']->setTimezone('Asia/Phnom_Penh')->format('M d, Y h:i A') }}
                                    </td>
                                    <td>
                                        @if ($stock['current_quantity'] > $stock['initial_quantity'])
                                            <span class="badge bg-success">Stock In</span>
                                        @elseif ($stock['current_quantity'] < $stock['initial_quantity'])
                                            <span class="badge bg-success">Stock In</span>
                                        @else
                                            <span class="badge bg-danger">Stock Out</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
