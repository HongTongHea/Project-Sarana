@extends('layouts.app')

@section('title', 'Orders')

@section('content')
    <div class="card rounded-0">
        <div class="card-body">
            <div class="row m-2 align-items-center">
                <div class="col-8 p-0">
                    <h2>Orders</h2>
                    <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm rounded-5">Add New Order</a>
                </div>
                <div class="col-4">
                    <div class="row align-items-center">
                        <div class="input-group rounded-5">
                            <input type="text" id="search" placeholder="Search ..."
                                class="form-control rounded-4 border position-relative" />
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-sm table-hover mt-3 search-table" id="OrderTableData">
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
                <tbody id="tableBody">
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
                                    <button class="btn btn-warning dropdown-toggle btn-sm rounded-5" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('orders.show', $order->id) }}">View
                                                Detail</a></li>
                                        <li><a class="dropdown-item" href="{{ route('orders.edit', $order->id) }}">Edit</a>
                                        </li>
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
            <div class="d-flex justify-content-Start ">
                <button id="prevBtn" class="btn border btn-sm me-2 rounded-5 border-dark txt-dark" onclick="prevPage()"
                    disabled><i class="fa-solid fa-angle-left"></i> Previous</button>
                <button id="nextBtn" class="btn border btn-sm rounded-5 border-dark txt-dark" onclick="nextPage()">Next <i
                        class="fa-solid fa-angle-right"></i></button>
            </div>
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
