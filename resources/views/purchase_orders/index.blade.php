@extends('layouts.app')

@section('title', 'Angkor Tech Computer | Purchase Orders')

@section('content')

    <div class="container-fluid mt-3">
        <div class="card shadow rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-semibold text-uppercase">Purchase Orders</h4>
                </div>
            </div>
            <div class="card-body">
                <button class="btn btn-primary btn-sm mb-3 ml-3" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="fas fa-plus"></i> New Purchase Order
                </button>
                <div class="table-responsive">
                    <table id="DataTable" class="table mt-3 table-border table-hover ">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Supplier</th>
                                <th>Order Date</th>
                                <th>Items</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->supplier->name ?? 'N/A' }}</td>
                                    <td>{{ $order->order_date->setTimezone('Asia/Phnom_Penh')->format('M d, Y h:i A') }}
                                    </td>
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
                                    <td>${{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : 'success' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->creator->name ?? 'N/A' }}</td>
                                    <td class="text-nowrap text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton{{ $order->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false" title="Actions">
                                                <i class="fas fa-ellipsis-v fs-6"></i>
                                            </button>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $order->id }}">
                                                <!-- Edit -->
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $order->id }}">
                                                        <i class="fa-solid fa-pen-to-square me-2 text-warning"></i>
                                                        Edit
                                                    </button>
                                                </li>

                                                <!-- Mark as Received -->
                                                @if ($order->status == 'pending')
                                                    <li>
                                                        <form
                                                            action="{{ route('purchase_orders.markReceived', $order->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                class="dropdown-item d-flex align-items-center">
                                                                <i class="fa-solid fa-check me-2 text-success"></i>
                                                                Mark as Received
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif

                                                <!-- Delete -->
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @foreach ($orders as $order)
        @include('purchase_orders.edit', [
            'purchaseOrder' => $order,
            'suppliers' => $suppliers,
            'products' => $products,
            'employees' => $employees,
        ])
        @include('purchase_orders.delete', ['purchaseOrder' => $order])
    @endforeach
    <!-- Create Purchase Order Modal -->
    @include('purchase_orders.create')

@endsection
