@extends('layouts.app')

@section('title', 'POS System | Orders')

@section('content')
    <div class="container-fluid mt-3">
        <div class="card rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-semibold">Order History</h4>
                </div>
            </div>
            <div class="card-body">
                <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm mb-3 ml-3">
                    <i class="fas fa-plus"></i> New Order
                </a>
                <div class="table-responsive">
                    <table id="DataTable" class="table mt-3 table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Order #</th>
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
                            @foreach ($orders as $order)
                                <tr>
                                    <td>ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $order->customer->name }}</td>
                                    <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                    <td>
                                        @foreach ($order->items as $item)
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
                                    <td>{{ $order->items->count() }}</td>
                                    <td>${{ number_format($order->subtotal, 2) }}</td>
                                    <td>${{ number_format($order->tax_amount, 2) }}</td>
                                    <td>${{ number_format($order->discount_amount, 2) }}</td>
                                    <td>${{ number_format($order->total, 2) }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $order->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="text-nowrap text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton{{ $order->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false" title="Actions">
                                                <i class="fas fa-ellipsis-v fs-6"></i>
                                            </button>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $order->id }}">
                                                <!-- View Order -->
                                                <li>
                                                    <a href="{{ route('orders.show', $order->id) }}"
                                                        class="dropdown-item d-flex align-items-center">
                                                        <i class="fa-solid fa-file-invoice me-2 text-info"></i>
                                                        View Invoice
                                                    </a>
                                                </li>

                                                <!-- Edit Order -->
                                                <li>
                                                    <a href="{{ route('orders.edit', $order->id) }}"
                                                        class="dropdown-item d-flex align-items-center">
                                                        <i class="fas fa-edit me-2 text-warning"></i>
                                                        Edit
                                                    </a>
                                                </li>

                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $order->id }}">
                                                        <i class="fa-solid fa-trash me-2 text-danger"></i>
                                                        Delete
                                                    </button>
                                                </li>


                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @include('Orders.delete', ['order' => $order])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
