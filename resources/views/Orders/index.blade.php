<!-- resources/views/order_products/index.blade.php -->

@extends('layouts.app')

@section('title', 'Orders Data')

@section('content')
    <div class="container mt-2" data-aos="fade-down" data-aos-duration="1000">
        <h3 class="m-3">Orders Data</h3>
        <div class="card">
            <div class="card-body">
                <div class="row m-2 align-items-center">
                    <div class="col-8 p-0">

                        <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm rounded-5"><i
                                class="fa-solid fa-circle-plus"></i> New Order</a>
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
                <div class="table-responsive">
                    <table class="table table-sm table-hover mt-3 search-table">
                        <thead class="table-warning">
                            <tr>
                                <th>No</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Payment Status</th>
                                <th>Products</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $order->customer->first_name . ' ' . $order->customer->last_name }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ $order->payment_status }}</td>
                                    {{-- <td>{{ $order->product->name }}</td> --}}
                                    <td>{{ $order->quantity }}</td>
                                    <td>{{ $order->price }}</td>
                                    <td>{{ $order->total_price }}</td>
                                    <td>
                                        <div class="dropdown align-items-center d-flex">

                                            @if ($order->status == 'completed' && $order->payment_status == 'unpaid')
                                                <a href="{{ route('payments.create', $order->id) }}"
                                                    class="btn btn-sm btn-primary text-white rounded-5 ">Payment</a>
                                            @endif

                                            <button class="btn btn-warning rounded-5 btn-sm dropdown-toggle ms-1"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu">
                                                @if (Auth::user()->role === 'admin')
                                                    <li>
                                                        <a href="{{ route('orders.show', $order->id) }}"
                                                            class="dropdown-item">View Payment</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('orders.edit', $order->id) }}"
                                                            class="dropdown-item">Edit</a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('orders.destroy', $order->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item"
                                                                onclick="return confirm('Are you sure?')">Delete</button>
                                                        </form>
                                                    </li>
                                                @elseif (Auth::user()->role === 'staff')
                                                    <li>
                                                        <a href="{{ route('orders.show', $order->id) }}"
                                                            class="dropdown-item">View Payment</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('orders.edit', $order->id) }}"
                                                            class="dropdown-item">Edit</a>
                                                    </li>
                                                @elseif (Auth::user()->role === 'customer')
                                                    <li>
                                                        <a href="{{ route('orders.show', $order->id) }}"
                                                            class="dropdown-item">View Payment</a>
                                                    </li>
                                                @endif
                                            </ul>

                                        </div>

                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-Start  mb-3">
                        <button id="prevBtn" class="btn border btn-sm me-2 rounded-5 border-dark txt-dark"
                            onclick="prevPage()" disabled><i class="fa-solid fa-angle-left"></i> Previous</button>
                        <button id="nextBtn" class="btn border btn-sm rounded-5 border-dark txt-dark"
                            onclick="nextPage()">Next <i class="fa-solid fa-angle-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
