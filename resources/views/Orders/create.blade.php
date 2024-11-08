@extends('layouts.app')

@section('title', 'Create Order')

@section('content')
    <div class="card">
        <div class="card-body">
         
            <h1>Create New Order</h1>

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="customer_id">Customer</label>
                    <select name="customer_id" id="customer_id" class="form-control" required>
                        <option value="">Select a customer</option>
                        @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->first_name }} {{ $customer->last_name }}
                                </option>
                            @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="product_id">Product</label>
                    <select name="product_id" id="product_id" class="form-control" required>
                        <option value="">Select a product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="canceled">Canceled</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="payment_status">Payment Status</label>
                    <select name="payment_status" id="payment_status" class="form-control" required>
                        <option value="unpaid">Unpaid</option>
                        <option value="paid">Paid</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" name="price" id="price" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="total_price">Total Price</label>
                    <input type="text" name="total_price" id="total_price" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary mt-3 btn-sm rounded-5">Create Order</button>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3 btn-sm rounded-5">Cancel</a>
            </form>
   

    </div>
</div>


@endsection
