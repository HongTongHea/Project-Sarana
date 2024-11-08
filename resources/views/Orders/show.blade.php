@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <div class="invoice-container mb-2" style="width: 80%; margin: auto; border: 1px solid #ddd; padding: 20px;">
            <h2 class="text-center">Order Invoice</h2>
            <div style="display: flex; justify-content: space-between;">
                <div>
                    <h4>Customer Information</h4>
                    <p><strong>Name:</strong> {{ $order->customer->first_name . ' ' . $order->customer->last_name }}</p>
                    <p><strong>Email:</strong> {{ $order->customer->email }}</p>
                    <p><strong>Address:</strong> {{ $order->customer->address }}</p>
                </div>
                <div style="text-align: right;">
                    <h4>Order Details</h4>
                    <p><strong>Order ID:</strong> {{ $order->id }}</p>
                    <p><strong>Date:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                </div>
            </div>

            <table class="table" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
                <thead style="background-color: #f5f5f5;">
                    <tr>
                        <th style="padding: 8px; border: 1px solid #ddd;">Product</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Price</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Quantity</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $order->product->name }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${{ number_format($order->price, 2) }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $order->quantity }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${{ number_format($order->total_price, 2) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"
                            style="padding: 8px; text-align: right; font-weight: bold; border: 1px solid #ddd;">
                            Grand Total</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${{ number_format($order->total_price, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            <div style="margin-top: 20px;">
                <h4>Payment Status: {{ ucfirst($order->payment_status) }}</h4>
            </div>

            <div class="text-center" style="margin-top: 30px;">
                <button onclick="window.print();" class="btn btn-primary">Print Invoice</button>
            </div>
        </div>
    </div>


    <style>
        /* Print styles */
        @media print {
            body * {
                visibility: hidden;
            }

            .invoice-container,
            .invoice-container * {
                visibility: visible;
            }

            .invoice-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 20px;
                margin: 0;
            }

            .btn {
                display: none;
            }
        }
    </style>
@endsection
