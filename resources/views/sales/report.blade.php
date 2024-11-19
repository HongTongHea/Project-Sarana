<div>
    <!-- Do what you can, with what you have, where you are. - Theodore Roosevelt -->
</div>
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sales Report</h1>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h4>Total Revenue</h4>
                    <p>${{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h4>Total Quantity Sold</h4>
                    <p>{{ $totalQuantity }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h4>Total Sales</h4>
                    <p>{{ $totalSales }}</p>
                </div>
            </div>
        </div>
    </div>

    <h2>Revenue Per Product</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($revenuePerProduct as $data)
            <tr>
                <td>{{ $data->product->name ?? 'Unknown Product' }}</td>
                <td>${{ number_format($data->total_revenue, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Quantity Sold Per Product</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Total Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quantityPerProduct as $data)
            <tr>
                <td>{{ $data->product->name ?? 'Unknown Product' }}</td>
                <td>{{ $data->total_quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Revenue Per Customer</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($revenuePerCustomer as $data)
            <tr>
                <td>{{ $data->customer->name ?? 'Unknown Customer' }}</td>
                <td>${{ number_format($data->total_revenue, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
