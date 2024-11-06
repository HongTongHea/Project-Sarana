@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Order Items List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Order ID</th>
                    <th>Product ID</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderItems as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->order_id }}</td>
                        <td>{{ $item->product_id }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
