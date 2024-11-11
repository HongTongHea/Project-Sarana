@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <h2 class="m-3">Edit Order</h2>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">


                        <div class="form-group col-12 col-md-6">
                            <label for="customer_id">Customer</label>
                            <select name="customer_id" id="customer_id" class="form-control" required>
                                <option value="">Select a customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ $order->customer_id == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->first_name }} {{ $customer->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="product_id">Product</label>
                            <select name="product_id" id="product_id" class="form-control" required>
                                <option value="">Select a product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ $order->product_id == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="payment_status">Payment Status</label>
                            <select name="payment_status" id="payment_status" class="form-control" required>
                                <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid
                                </option>
                                <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control"
                                value="{{ $order->quantity }}" required>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="price">Price</label>
                            <input type="text" name="price" id="price" class="form-control"
                                value="{{ $order->price }}" required>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="total_price">Total Price</label>
                            <input type="text" name="total_price" id="total_price" class="form-control"
                                value="{{ $order->total_price }}" required>
                        </div>
                    </div>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-sm rounded-5  float-end">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm rounded-5 float-end me-1">Update Order</button>
                </form>
            </div>
        </div>
    </div>
@endsection
