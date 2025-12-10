@extends('layouts.app')

@section('title', 'AngkorTech Computer | Sales History')

@section('content')
    <div class="container-fluid mt-3">
        <div class="card rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-semibold">Sales History</h4>
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
                                <th>Sale</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Items</th>
                                {{-- <th>Qty</th> --}}
                                <th>Subtotal</th>
                                <th>Tax</th>
                                <th>Discount</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>SALE-{{ str_pad($sale->id, 2, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $sale->customer->name }}</td>
                                    <td>{{ $sale->created_at->setTimezone('Asia/Phnom_Penh')->format('M d, Y h:i A') }}</td>
                                    <td>
                                        @foreach ($sale->items as $item)
                                            @if ($item->item)
                                                @if ($item->item_type === 'App\Models\Product')
                                                    {{ $item->item->name }}&nbsp; <br>
                                                @elseif ($item->item_type === 'App\Models\Accessory')
                                                    {{ $item->item->name }}
                                                @endif
                                            @else
                                                Item Deleted
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $sale->items->count() }}</td>
                                    <td>${{ number_format($sale->subtotal, 2) }}</td>
                                    <td>${{ number_format($sale->tax_amount, 2) }}</td>
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
                                                <!-- View Sale -->
                                                <li>
                                                    {{-- <a href="{{ route('sales.show', $sale->id) }}"
                                                        class="dropdown-item d-flex align-items-center">
                                                        <i class="fa-solid fa-file-invoice me-2 text-info"></i>
                                                        View Invoice
                                                    </a> --}}

                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#invoiceModal{{ $sale->id }}">
                                                        <i class="fa-solid fa-receipt me-2 text-info"></i>
                                                        View Invoice
                                                    </button>
                                                </li>

                                                <!-- Edit Sale -->
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
@endsection
