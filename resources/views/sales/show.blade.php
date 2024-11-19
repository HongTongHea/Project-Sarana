@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mt-3 rounded-0">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Sale Details</h2>
            </div>
            <div class="card-body">
                <h4>Sale Summary</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Order ID:</strong> {{ $sale->order_id }}
                    </li>
                    <li class="list-group-item">
                        <strong>Product Name:</strong> {{ $sale->product->name }}
                    </li>
                    <li class="list-group-item">
                        <strong>Customer Name:</strong> {{ $sale->customer->first_name }} {{ $sale->customer->last_name }}
                    </li>
                    <li class="list-group-item">
                        <strong>Quantity Sold:</strong> {{ $sale->quantity }}
                    </li>
                    <li class="list-group-item">
                        <strong>Unit Price:</strong> ${{ number_format($sale->price, 2) }}
                    </li>
                    <li class="list-group-item">
                        <strong>Total Price:</strong> ${{ number_format($sale->total_price, 2) }}
                    </li>
                    <li class="list-group-item">
                        <strong>Sale Date:</strong> {{ \Carbon\Carbon::parse($sale->sale_date)->format('F j, Y, g:i a') }}
                    </li>
                </ul>

                <hr>

                <h4>Product Details</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Product ID: </strong> {{ $sale->product->id }}
                    </li>
                    <li class="list-group-item">
                        <strong>Product Name: </strong> {{ $sale->product->name }}
                    </li>
                    <li class="list-group-item">
                        <strong>Product Description: </strong> {{ $sale->product->description }}
                    </li>
                    <li class="list-group-item">
                        <strong>Category:</strong> {{ $sale->product->category->name ?? 'N/A' }}
                    </li>
                </ul>

                <hr>

                <h4>Customer Details</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Customer ID:</strong> {{ $sale->customer->id }}
                    </li>
                    <li class="list-group-item">
                        <strong>Cutomer Name:</strong> {{ $sale->customer->first_name }} {{ $sale->customer->last_name }}
                    </li>
                    <li class="list-group-item">
                        <strong>Email:</strong> {{ $sale->customer->email }}
                    </li>
                    <li class="list-group-item">
                        <strong>Phone:</strong> {{ $sale->customer->phone }}
                    </li>
                </ul>

                <hr>

                <h4>Additional Information</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Created At:</strong>
                        {{ \Carbon\Carbon::parse($sale->created_at)->format('F j, Y, g:i a') }}
                    </li>
                    <li class="list-group-item">
                        <strong>Last Updated:</strong>
                        {{ \Carbon\Carbon::parse($sale->updated_at)->format('F j, Y, g:i a') }}
                    </li>
                </ul>

                <hr>

                <div class="text-dark">
                    <h3>Sales Insights</h3>
                </div>
                <div class="card-body">
                    <p><strong>Total Sales for Product "{{ $sale->product->name }}":</strong>
                        ${{ number_format($totalSalesForProduct, 2) }}</p>
                    <p><strong>Total Quantity Sold for Product "{{ $sale->product->name }}":</strong>
                        {{ $totalQuantityForProduct }}</p>
                    <p><strong>Total Sales for Customer "{{ $sale->customer->first_name }} {{ $sale->customer->last_name }}":</strong>
                        ${{ number_format($totalSalesForCustomer, 2) }}</p>
                </div>

                <div class="card-footer text-end">
                    <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                    <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-primary btn-sm">Edit Sale</a>
                </div>
            </div>

        </div>
    </div>
    
@endsection
