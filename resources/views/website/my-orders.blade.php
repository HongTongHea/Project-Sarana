@extends('website.app') @section('content')
    <div class="container mt-5" style="margin-top: 100px !important; margin-bottom: 50px !important;">
        <div class="orders-header">
            <h1 class="fw-bold text-uppercase" style="font-size: 2.5rem;">My Orders</h1>
            <p class="orders-subtitle">Details and manage your orders</p>
        </div>

        @if ($orders->count() > 0)
            <div class="orders-list">
                <div class="table-responsive">
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Image</th>
                                <th>Items</th>
                                <th>Name</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="order-number">
                                        <strong>#{{ $order->order_number }}</strong>
                                    </td>
                                    <td class="order-date">{{ $order->created_at->format('M j, Y') }}</td>
                                    <td>
                                        @php
                                            $firstItem = $order->items->first();
                                        @endphp

                                        @if ($firstItem && $firstItem->item && $firstItem->item->picture_url)
                                            <img src="{{ Storage::url($firstItem->item->picture_url) }}"
                                                alt="{{ $firstItem->item_name }}" class="rounded me-3"
                                                style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center me-3"
                                                style="width: 60px; height: 60px;">
                                                <i class="fas fa-box text-white" style="font-size: 0.8rem;"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="order-items">{{ $order->items_count }} items</td>
                                    <td class="order-name">
                                        @if ($order->items->count() > 0)
                                            @foreach ($order->items as $item)
                                                {{ $item->product->name ?? ($item->item_name ?? 'Product') }}
                                                @if (!$loop->last)
                                                    <br>
                                                @endif
                                            @endforeach
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="order-total">${{ number_format($order->total_amount, 2) }}</td>
                                    <td class="order-status">
                                        <span class="status-badge status-{{ strtolower($order->status) }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="order-payment">
                                        <span class="payment-badge payment-{{ strtolower($order->payment_status) }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="orders-pagination">
                    {{ $orders->links() }}
                </div>

                <p class="mt-4 text-muted small text-center">
                    Thank you for shopping with us. If you have any questions or need assistance, please don't
                    hesitate to contact us.
                </p>
            </div>
        @else
            <div class="orders-empty">
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                    </div>
                    <h3 class="empty-title">No orders yet</h3>
                    <p class="empty-description">You haven't placed any orders yet.</p>
                    <a href="#" class="btn-start-shopping">Start Shopping</a>
                </div>
            </div>
        @endif
    </div>
    @include('website.shoppingcart')
@endsection

<style>
    .orders-header {
        margin-bottom: 2.5rem;
        border-bottom: 1px solid #eaeaea;
        padding-bottom: 1.5rem;
    }

    .orders-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 0 0.5rem 0;
    }

    .orders-subtitle {
        font-size: 1rem;
        color: #666;
        margin: 0;
    }


    .table-responsive {
        overflow-x: auto;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        border: 1px solid #eaeaea;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
    }

    .orders-table thead {
        background-color: #f8f9fa;
    }

    .orders-table th {
        padding: 1.125rem 1.5rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.875rem;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #eaeaea;
    }

    .orders-table td {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.95rem;
        vertical-align: middle;
    }

    .orders-table tbody tr:last-child td {
        border-bottom: none;
    }

    .orders-table tbody tr:hover {
        background-color: #fafafa;
        transition: background-color 0.2s ease;
    }


    .order-number {
        font-weight: 600;
        color: #2c3e50;
    }


    .status-badge,
    .payment-badge {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-align: center;
        min-width: 85px;
    }

    .status-pending,
    .payment-pending {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .status-processing,
    .payment-processing {
        background-color: #cce5ff;
        color: #004085;
        border: 1px solid #b8daff;
    }

    .status-completed,
    .payment-paid,
    .payment-completed {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status-cancelled,
    .payment-failed,
    .payment-cancelled {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .status-shipped {
        background-color: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }


    .orders-pagination {
        margin-top: 2.5rem;
        display: flex;
        justify-content: center;
    }


    .orders-empty {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 400px;
    }

    .empty-state {
        text-align: center;
        max-width: 400px;
        padding: 3rem 2rem;
    }

    .empty-icon {
        margin-bottom: 1.5rem;
        color: #a0a0a0;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.75rem;
    }

    .empty-description {
        color: #666;
        font-size: 1rem;
        margin-bottom: 2rem;
        line-height: 1.5;
    }

    .btn-start-shopping {
        display: inline-block;
        padding: 0.875rem 2rem;
        background-color: #4a6cf7;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-weight: 600;
        transition: all 0.2s ease;
        border: none;
        font-size: 1rem;
    }

    .btn-start-shopping:hover {
        background-color: #3a5ce5;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 108, 247, 0.25);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {


        .orders-table th,
        .orders-table td {
            padding: 0.875rem 1rem;
        }

        .status-badge,
        .payment-badge {
            min-width: 75px;
            padding: 0.3rem 0.6rem;
            font-size: 0.75rem;
        }

        .btn-view-details {
            padding: 0.4rem 0.875rem;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 576px) {

        .orders-table th:nth-child(3),
        .orders-table td:nth-child(3) {
            display: none;
        }
    }
</style>
