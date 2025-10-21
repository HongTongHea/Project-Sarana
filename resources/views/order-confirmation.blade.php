@extends('website.app')
@section('content')
    <div class="container" style="margin-top: 100px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="fas fa-check-circle me-2"></i>Order Confirmed!</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle text-success mb-3" style="font-size: 4rem;"></i>
                            <h3 class="text-success mb-3">Thank You for Your Order!</h3>
                            <p class="lead">Your order has been placed successfully.</p>
                        </div>

                        @if (isset($order) && $order)
                            <div class="alert alert-info">
                                <h5>Order Details</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Order Number:</strong> #{{ $order->order_number }}</p>
                                        <p><strong>Order Date:</strong> {{ $order->created_at->format('M j, Y g:i A') }}</p>
                                        <p><strong>Status:</strong> <span
                                                class="badge bg-warning">{{ ucfirst($order->status) }}</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Subtotal:</strong> ${{ number_format($order->subtotal, 2) }}</p>
                                        <p><strong>Shipping:</strong> ${{ number_format($order->shipping_amount, 2) }}</p>
                                        <p><strong>Tax:</strong> ${{ number_format($order->tax_amount, 2) }}</p>
                                        <p><strong class="fs-5">Total:</strong>
                                            ${{ number_format($order->total_amount, 2) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h5>Shipping Address</h5>
                                <p class="text-muted">{{ nl2br(e($order->shipping_address)) }}</p>
                            </div>
                        @endif

                        <div class="text-center mt-4">
                            <a href="{{ route('online-orders.index') }}" class="btn btn-primary me-2">
                                <i class="fas fa-list me-1"></i>View My Orders
                            </a>
                            <a href="/" class="btn btn-outline-secondary">
                                <i class="fas fa-shopping-bag me-1"></i>Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
