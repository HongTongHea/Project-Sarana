@extends('website.app') @section('content')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');

        .orders-wrap {
            font-family: 'Inter', sans-serif;
            max-width: 1320px;
            margin: 150px auto 80px;
            padding: 0 24px;
        }

        .orders-wrap h1 {
            font-size: 3rem;
            text-transform: uppercase;
            font-weight: 600;
            color: #111;
            margin: 0 0 4px;
        }

        .orders-wrap .subtitle {
            font-size: 0.875rem;
            color: #888;
            margin: 0 0 40px;
        }

        /* Table */
        .orders-card {
            background: #fff;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background: #FAFAFA;
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #9CA3AF;
            padding: 14px 20px;
            text-align: left;
            border-bottom: 1px solid #E5E7EB;
        }

        tbody tr {
            border-bottom: 1px solid #F3F4F6;
            transition: background 0.15s;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #FAFAFA;
        }

        tbody td {
            padding: 16px 20px;
            font-size: 0.875rem;
            color: #374151;
            vertical-align: middle;
        }

        .order-num {
            font-weight: 600;
            color: #111;
        }

        .order-date {
            color: #9CA3AF;
            font-size: 0.82rem;
        }

        .thumb {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #E5E7EB;
            display: block;
        }

        .thumb-placeholder {
            width: 48px;
            height: 48px;
            background: #F3F4F6;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9CA3AF;
            font-size: 0.8rem;
        }

        .product-names {
            color: #374151;
            line-height: 1.6;
        }

        .order-total {
            font-weight: 600;
            color: #111;
        }

        /* Badges */
        .badge {
            display: inline-block;
            font-size: 0.72rem;
            font-weight: 500;
            padding: 4px 10px;
            border-radius: 6px;
            white-space: nowrap;
        }

        .status-pending {
            background: #FEF9C3;
            color: #854D0E;
        }

        .status-processing {
            background: #DBEAFE;
            color: #1D4ED8;
        }

        .status-shipped {
            background: #E0F2FE;
            color: #0369A1;
        }

        .status-delivered {
            background: #DCFCE7;
            color: #166534;
        }

        .status-cancelled {
            background: #FEE2E2;
            color: #991B1B;
        }

        .status-refunded {
            background: #F3F4F6;
            color: #374151;
        }

        .payment-paid {
            background: #DCFCE7;
            color: #166534;
        }

        .payment-unpaid {
            background: #FEE2E2;
            color: #991B1B;
        }

        .payment-pending {
            background: #FEF9C3;
            color: #854D0E;
        }

        .payment-refunded {
            background: #F3F4F6;
            color: #374151;
        }

        .payment-failed {
            background: #FEE2E2;
            color: #991B1B;
        }

        /* Pagination */
        .pagination-wrap {
            padding: 20px;
            display: flex;
            justify-content: center;
            border-top: 1px solid #F3F4F6;
        }

        .orders-footer {
            text-align: center;
            font-size: 0.8rem;
            color: #9CA3AF;
            margin-top: 24px;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 80px 24px;
        }

        .empty-icon {
            width: 64px;
            height: 64px;
            background: #F3F4F6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: #9CA3AF;
        }

        .empty-state h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #111;
            margin: 0 0 8px;
        }

        .empty-state p {
            font-size: 0.875rem;
            color: #6B7280;
            margin: 0 0 28px;
        }

        .btn-shop {
            display: inline-block;
            background: #111;
            color: #fff;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 11px 28px;
            border-radius: 8px;
            text-decoration: none;
            transition: opacity 0.15s;
        }

        .btn-shop:hover {
            opacity: 0.8;
            color: #fff;
        }

        @media (max-width: 640px) {
            .hide-sm {
                display: none;
            }

            thead th,
            tbody td {
                padding: 12px 14px;
            }
        }
    </style>

    <div class="orders-wrap">
        <h1>My Orders</h1>
        <p class="subtitle">Track and manage your purchases</p>

        @if ($orders->count() > 0)
            <div class="orders-card">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th class="hide-sm">Date</th>
                                <th>Item</th>
                                <th>Product</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="order-num">#{{ $order->order_number }}</td>
                                    <td class="order-date hide-sm">{{ $order->created_at->format('M j, Y') }}</td>
                                    <td>
                                        @php $firstItem = $order->items->first(); @endphp
                                        @if ($firstItem && $firstItem->item && $firstItem->item->picture_url)
                                            <img src="{{ Storage::url($firstItem->item->picture_url) }}"
                                                alt="{{ $firstItem->item_name }}" class="thumb">
                                        @else
                                            <div class="thumb-placeholder">
                                                <i class="fas fa-box"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="product-names">
                                        @forelse ($order->items as $item)
                                            {{ $item->product->name ?? ($item->item_name ?? 'Product') }}@if (!$loop->last)
                                                <br>
                                            @endif
                                            @empty
                                                <span style="color:#9CA3AF">—</span>
                                            @endforelse
                                        </td>
                                        <td class="order-total">${{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge status-{{ strtolower($order->status) }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge payment-{{ strtolower($order->payment_status) }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-wrap">
                        {{ $orders->links() }}
                    </div>
                </div>

                <p class="orders-footer">Need help? Contact our support team anytime.</p>
            @else
                <div class="orders-card">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>
                        </div>
                        <h3>No orders yet</h3>
                        <p>You haven't placed any orders. Start shopping to see them here.</p>
                        <a href="/" class="btn-shop">Start Shopping</a>
                    </div>
                </div>
            @endif
        </div>

        @include('website.shoppingcart')
    @endsection
