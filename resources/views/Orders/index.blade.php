@extends('layouts.app')

@section('title', 'Orders')

@section('content')
    <div class="card rounded-0">
        <div class="card-body">
            <h2>Orders</h2>
            <div class="row m-1 align-items-center">
                <div class="col-8 p-0">
                    <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">Create New Order</a>
                </div>

                <div class="col-4">
                    <div class="row align-items-center">
                        <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                            <div class="input-group rounded-5">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pe-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input type="text" id="search" placeholder="Search ..." class="form-control" />
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
            <table class="table table-responsive table-sm table-hover mt-3" id="Table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Total Price</th>
                        <th>Payment Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer->first_name }} {{ $order->customer->last_name }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>{{ number_format($order->total_price, 2) }}</td>
                            <td>{{ ucfirst($order->payment_status) }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item"
                                                href="{{ route('orders.show', $order->id) }}">View Detail</a></li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('orders.edit', $order->id) }}">Edit</a></li>
                                        <li>
                                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item">Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
