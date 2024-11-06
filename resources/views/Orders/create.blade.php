@extends('layouts.app')

@section('title', 'Create Order')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1>Create New Order</h1>

            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Customer Selection -->
                    <div class="form-group col-12 col-md-6">
                        <label for="customer_id">Customer</label>
                        <select name="customer_id" id="customer_id" class="form-control @error('customer_id') is-invalid @enderror">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->first_name }} {{ $customer->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Order Status -->
                    <div class="form-group col-12 col-md-6">
                        <label for="status">Order Status</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="canceled" {{ old('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Payment Status -->
                    <div class="form-group col-12 col-md-6">
                        <label for="payment_status">Payment Status</label>
                        <select name="payment_status" id="payment_status" class="form-control @error('payment_status') is-invalid @enderror">
                            <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ old('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                        @error('payment_status')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Total Price -->
                    <div class="form-group col-12 col-md-6">
                        <label for="total_price">Total Price</label>
                        <input type="number" name="total_price" id="total_price" class="form-control @error('total_price') is-invalid @enderror"
                               value="{{ old('total_price') }}" step="0.01" required>
                        @error('total_price')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <h4 class="mt-4">Order Items</h4>
                <div id="order-items">
                    @for($i = 0; $i < 1; $i++)
                        <div class="order-item mb-3">
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="product_id_{{ $i }}">Product</label>
                                    <select name="product_id[]" id="product_id_{{ $i }}" class="form-control @error('product_id.*') is-invalid @enderror">
                                        <option value="">Select Product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ old("product_id.$i") == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error("product_id.$i")
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-12 col-md-3">
                                    <label for="quantity_{{ $i }}">Quantity</label>
                                    <input type="number" name="quantity[]" id="quantity_{{ $i }}" class="form-control @error('quantity.*') is-invalid @enderror"
                                           value="{{ old("quantity.$i") }}" required min="1">
                                    @error("quantity.$i")
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-12 col-md-3">
                                    <label for="price_{{ $i }}">Price</label>
                                    <input type="number" name="price[]" id="price_{{ $i }}" class="form-control @error('price.*') is-invalid @enderror"
                                           value="{{ old("price.$i") }}" step="0.01" required>
                                    @error("price.$i")
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary mt-3 btn-sm">Create Order</button>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3 btn-sm">Cancel</a>
            </form>
        </div>
    </div>
@endsection
