@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <h3>Edit Order</h3>
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('orders.update', $order->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Customer Selection -->
                    <div class="row d-flex flex-column">
                        <div class="col-12 mb-3">
                            <label class="form-label">Customer</label>
                            <select class="form-control" name="customer_id" required>
                                <option value="">Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ $order->customer_id == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->first_name }} {{ $customer->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Order Status and Payment Status -->
                        <div class="col-12 mb-3">
                            <label class="form-label">Order Status</label>
                            <select class="form-control" name="status" required>
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Payment Status</label>
                            <select class="form-control" name="payment_status" required>
                                <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                        </div>

                        <!-- Total Price -->
                        <div class="col-12 mb-3">
                            <label class="form-label">Total Price</label>
                            <input type="number" name="total_price" value="{{ old('total_price', $order->total_price) }}" class="form-control" required />
                        </div>

                        <!-- Products Section -->
                        <h4 class="mt-3">Order Items</h4>
                        @foreach ($order->orderItems as $index => $item)
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Product</label>
                                    <select class="form-control" name="product_id[{{ $index }}]" required>
                                        <option value="">Select Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Quantity</label>
                                    <input type="number" class="form-control" name="quantity[{{ $index }}]" value="{{ old('quantity.' . $index, $item->quantity) }}" min="1" required>
                                </div>
                                <div class="col-md-4">
                                    <label>Price</label>
                                    <input type="number" class="form-control" name="price[{{ $index }}]" value="{{ old('price.' . $index, $item->price) }}" step="0.01" min="0" required>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Submit Button -->
                    <button class="btn btn-sm btn-primary mt-3">Update Order</button>
                    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-danger mt-3">Back</a>
                </form>
            </div>
        </div>
    </div>
@endsection
