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
                                <th>Items</th>
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
                                    <td>{{ $order->customer->name ?? 'Walk-in' }}</td>
                                    <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
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
                                    <td>
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
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
