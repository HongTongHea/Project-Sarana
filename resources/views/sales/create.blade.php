@extends('layouts.app')

@section('content')
    <div class="container mt-3" data-aos="fade-down" data-aos-duration="1000">
        <h3 class="m-3">Create Sale</h3>
        <div class="card">
            <div class="card-body">

                <form action="{{ route('sales.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="order_id">Order</label>
                            <select class="form-control form-select" name="order_id" required>
                                <option value="" disabled selected>Select Order</option>
                                @foreach ($orders as $order)
                                    <option value="{{ $order->id }}">{{ $order->id }} - {{ $order->created_at }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Product Dropdown -->
                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="product_id">Product</label>
                            <select class="form-control form-select" name="product_id" required>
                                <option value="" disabled selected>Select Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="customer_id">Customer</label>
                            <select class="form-control form-select" name="customer_id" required>
                                <option value="" disabled selected>Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->first_name }}
                                        {{ $customer->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="quantity">Quantity</label>
                            <input class="form-control" type="number" name="quantity" id="quantity"
                                value="{{ old('quantity') }}" required min="1" oninput="calculateTotal()">
                        </div>

                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="price">Price</label>
                            <input class="form-control" type="number" name="price" id="price"
                                value="{{ old('price') }}" required step="0.01" oninput="calculateTotal()">
                        </div>

                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="total_price">Total Price</label>
                            <input class="form-control" type="number" name="total_price" id="total_price"
                                value="{{ old('total_price') }}" readonly>
                        </div>

                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="sale_date">Sale Date</label>
                            <input class="form-control" type="date" name="sale_date" value="{{ old('sale_date') }}"
                                required>
                        </div>

                    </div>
                    <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm rounded-5 float-end m-1">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm rounded-5 float-end m-1">Add Sale</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Function to calculate total price
        function calculateTotal() {
            const quantity = document.getElementById('quantity').value;
            const price = document.getElementById('price').value;
            const totalPriceField = document.getElementById('total_price');

            if (quantity && price) {
                totalPriceField.value = (quantity * price).toFixed(2); // Calculate total price
            }
        }
    </script>
@endsection
