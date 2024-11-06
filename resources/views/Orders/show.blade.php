@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
    <div class="card rounded-0">
        <div class="card-body">
            <h1>Order Details</h1>

            <!-- Order Information -->
            <div class="card mt-4 rounded-0 w-75 bg-dark text-white">
                <div class="card-header">
                    <h3>Order #{{ $order->id }}</h3>
                </div>
                <div class="card-body">
                    <p><strong>Customer:</strong> {{ $order->customer->first_name }} {{ $order->customer->last_name }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                    <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                    <p><strong>Total Price:</strong> ${{ number_format($order->total_price, 2) }}</p>
                    <p><strong>Created At:</strong> {{ $order->created_at->format('d-m-Y H:i') }}</p>
                    <p><strong>Updated At:</strong> {{ $order->updated_at->format('d-m-Y H:i') }}</p>

                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-sm">Back to List</a>

                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </div>

            <!-- Order Items -->
            <h4 class="mt-4">Order Items</h4>
            <table class="table table-dark table-hover table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items ?? [] as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'N/A' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                    </tr>
                @endforeach
                    

                </tbody>
            </table>
        </div>
    </div>
@endsection
