@extends('layouts.app')

@section('title', 'AngkorTech Computer | Online Orders')

@section('content')
    <div class="container-fluid mt-3">
        <div class="card rounded-0 shadow-sm">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-semibold text-uppercase">Orders</h4>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="DataTable" class="table table-border mt-3 table-hover ">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th>No</th>
                                <th>Order No</th>
                                <th>Customer Name</th>
                                {{-- <th>Email</th> --}}
                                <th>Phone</th>
                                <th>Subtotal</th>
                                <th>Discount</th>
                                <th>Shipping</th>
                                <th>Total</th>
                                <th>Payment</th>
                                {{-- <th>Address</th> --}}
                                {{-- <th>Order Date</th> --}}
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($onlineOrders as $order)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">#{{ $order->order_number ?? $order->id }}</td>
                                    <td>{{ $order->customer_first_name }} {{ $order->customer_last_name }}</td>
                                    {{-- <td>{{ $order->customer_email }}</td> --}}
                                    <td>{{ $order->customer_phone ?? '-' }}</td>
                                    <td class="text-end">${{ number_format($order->subtotal, 2) }}</td>
                                    <td class="text-end">${{ number_format($order->discount_amount, 2) }}</td>
                                    <td class="text-end">${{ number_format($order->shipping_amount, 2) }}</td>
                                    <td class="text-end"><strong>${{ number_format($order->total_amount, 2) }}</strong>
                                    </td>

                                    <td class="text-center">
                                        <span
                                            class="badge 
                                        @if ($order->payment_status === 'paid') bg-success 
                                        @elseif ($order->payment_status === 'pending') bg-warning
                                        @elseif ($order->payment_status === 'failed') bg-danger
                                        @else bg-secondary @endif">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>

                                    {{-- <td>{{ Str::limit($order->shipping_address, 30) }}</td> --}}
                                    {{-- <td>{{ $order->created_at->setTimezone('Asia/Phnom_Penh')->format('M d, Y h:i A') }} --}}
                                    </td>

                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton{{ $order->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $order->id }}">
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#showModal{{ $order->id }}">
                                                        <i class="fa-solid fa-circle-info me-2 text-info"></i>
                                                        View Details
                                                    </button>
                                                </li>
                                                @if (Auth::user()->role === 'admin')
                                                    <li>
                                                        <button class="dropdown-item d-flex align-items-center"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $order->id }}">
                                                            <i class="fa-solid fa-trash me-2 text-danger"></i>
                                                            Delete
                                                        </button>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @foreach ($onlineOrders as $order)
                        @include('online-orders.show')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
