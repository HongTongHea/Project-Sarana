@extends('layouts.app')

@section('title', 'AngkorTech Computer | Sales History')

@section('content')
    <div class="container-fluid mt-3">
        {{-- Summary Cards --}}
        <div class="row mt-5">
            <div class="col-md-6 col-lg-3">
                <div class="card rounded-0 card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Revenue</p>
                                    <h4 class="card-title">${{ number_format($sales->sum('total'), 2) }}
                                    </h4>
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
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Sales</p>
                                    <h4 class="card-title">
                                        {{ $sales->count() }}</h4>
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
                                    <p class="card-category">Items Sold</p>
                                    <h4 class="card-title">
                                        {{ $sales->sum(fn($s) => $s->items->sum('quantity')) }}</h4>
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
                                    <i class="fas fa-chart-line"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Discounts</p>
                                    <h4 class="card-title">
                                        ${{ number_format($sales->sum('additional_discount') + $sales->sum('item_discounts'), 2) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sales Table Card --}}
        <div class="card rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-semibold">Sales History</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 fw-semibold">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Sales History</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="card-body">
                <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm mb-3 ml-3">
                    <i class="fas fa-plus"></i> New Sale
                </a>
                <div class="table-responsive">
                    <table id="DataTable" class="table mt-3 table-border table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Sale</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th>Discount</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>SALE-{{ str_pad($sale->id, 2, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $sale->customer->name }}</td>
                                    <td>{{ $sale->created_at->setTimezone('Asia/Phnom_Penh')->format('M d, Y h:i A') }}
                                    </td>
                                    <td>
                                        <ul class="mb-0 ps-3">
                                            @foreach ($sale->items as $item)
                                                <li>
                                                    @if ($item->item)
                                                        @if ($item->item_type === 'App\Models\Product')
                                                            {{ $item->item->name }}
                                                        @elseif ($item->item_type === 'App\Models\Accessory')
                                                            {{ $item->item->name }}
                                                        @endif
                                                    @else
                                                        Item Deleted
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ $sale->items->sum('quantity') }}</td>
                                    <td>${{ number_format($sale->subtotal, 2) }}</td>
                                    <td>${{ number_format($sale->additional_discount, 2) }}</td>
                                    <td>${{ number_format($sale->total, 2) }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $sale->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                                            {{ ucfirst($sale->status) }}
                                        </span>
                                    </td>
                                    <td class="text-nowrap text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton{{ $sale->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false" title="Actions">
                                                <i class="fas fa-ellipsis-v fs-6"></i>
                                            </button>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $sale->id }}">
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#invoiceModal{{ $sale->id }}">
                                                        <i class="fa-solid fa-receipt me-2 text-info"></i>
                                                        View Invoice
                                                    </button>
                                                </li>
                                                <li>
                                                    <a href="{{ route('sales.edit', $sale->id) }}"
                                                        class="dropdown-item d-flex align-items-center">
                                                        <i class="fas fa-edit me-2 text-warning"></i>
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    @if (Auth::user()->role === 'admin')
                                                        <button class="dropdown-item d-flex align-items-center"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $sale->id }}">
                                                            <i class="fa-solid fa-trash me-2 text-danger"></i>
                                                            Delete
                                                        </button>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @foreach ($sales as $sale)
                        @include('Sales.show ', ['sale' => $sale])
                        @include('Sales.delete', ['sale' => $sale])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <style>
        .card-stats {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-stats:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2) !important;
        }
    </style>
@endsection
