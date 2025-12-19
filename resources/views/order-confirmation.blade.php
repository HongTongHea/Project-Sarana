<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/assets/img/logo-Company2.png" type="image/x-icon" />
    <title>Order Confirmed | AngkorTech Computer</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <style>
        body {
            background: #f5f7fa;
        }

        .order-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .success-icon {
            width: 90px;
            height: 90px;
            background: rgba(25, 135, 84, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
        }

        .success-icon i {
            font-size: 3rem;
            color: #198754;
        }

        .section-title {
            font-weight: 600;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .order-summary p {
            margin-bottom: 6px;
            font-size: 0.95rem;
        }

        .total-amount {
            font-size: 1.25rem;
            font-weight: 700;
            color: #198754;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <div class="card order-card">
                    <div class="card-body p-4 p-md-5">

                        <!-- Success Message -->
                        <div class="text-center mb-4">
                            <div class="success-icon mb-3">
                                <i class="fas fa-check"></i>
                            </div>
                            <h3 class="fw-bold text-success">Order Confirmed</h3>
                            <p class="text-muted mb-0">
                                Thank you for shopping with <strong>AngkorTech Computer</strong>.
                            </p>
                        </div>

                        @if (isset($order) && $order)
                            <!-- Order Info -->
                            <div class="bg-light rounded-3 p-4 mb-4">
                                <h5 class="section-title">Order Details</h5>
                                <div class="row order-summary">
                                    <div class="col-md-6">
                                        <p><strong>Order Number:</strong> #{{ $order->order_number }}</p>
                                        <p><strong>Items:</strong> {{ $order->items_count }}</p>
                                        <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y • h:i A') }}</p>
                                        <p>
                                            <strong>Status:</strong>
                                            <span class="badge bg-warning text-dark px-3 py-2">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="col-md-6">
                                        <p><strong>Subtotal:</strong> ${{ number_format($order->subtotal, 2) }}</p>
                                        <p><strong>Shipping:</strong> ${{ number_format($order->shipping_amount, 2) }}
                                        </p>
                                        <p class="total-amount">
                                            Total: ${{ number_format($order->total_amount, 2) }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Address -->
                            <div class="mb-4">
                                <h5 class="section-title">Shipping Address</h5>
                                <p class="text-muted mb-0">
                                    {{ nl2br(e($order->shipping_address)) }}
                                </p>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                            <a href="{{ route('my-orders.index') }}" class="btn btn-primary px-4">
                                <i class="fas fa-receipt me-2"></i>My Orders
                            </a>
                            <a href="/" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-store me-2"></i>Continue Shopping
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
