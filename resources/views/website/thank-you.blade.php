@extends('website.app')
@section('content')
    <div class="container py-5" style="margin-top: 6rem;">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="card border-0 shadow-sm">
                    <div class="card-body py-5">
                        <div class="text-success mb-4">
                            <i class="bi bi-check-circle-fill" style="font-size: 4rem;"></i>
                        </div>

                        <h1 class="fw-bold text-success mb-3">Thank You!</h1>
                        <h4 class="mb-4">Your order has been placed successfully</h4>

                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h5 class="fw-semibold">Order Details</h5>
                                <p class="mb-1">Order ID: <strong>#{{ $order->id }}</strong></p>
                                <p class="mb-1">Total Amount: <strong>${{ number_format($order->total, 2) }}</strong></p>
                                <p class="mb-0">Status: <span
                                        class="badge bg-warning">{{ ucfirst($order->status) }}</span></p>
                            </div>
                        </div>

                        <p class="text-muted mb-4">
                            A confirmation email has been sent to <strong>{{ $order->customer->email }}</strong>.
                            We'll send you a shipping confirmation when your order is on its way.
                        </p>

                        <div class="d-flex gap-3 justify-content-center">
                            <a href="{{ route('home') }}" class="btn btn-outline-primary">
                                <i class="bi bi-house"></i> Continue Shopping
                            </a>
                            <a href="{{ route('orders.tracking', $order->id) }}" class="btn btn-primary">
                                <i class="bi bi-truck"></i> Track Your Order
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
