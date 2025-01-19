@extends('layouts.app')

@section('title', 'Order Invoice')

@section('content')
    <div class="invoice-container" id="invoice" style="width: 80%; margin: auto; border: 1px solid #ddd; padding: 20px;"
        data-aos="fade-down" data-aos-duration="1000">
        <img src="{{ asset('assets/img/logo4.png') }}" alt="" style="width: 150px;" class="mb-2">

        <h2 class="text-center fw-bold text-uppercase">Order Invoice</h2>

        <!-- Order and Customer Information -->
        <div style="display: flex; justify-content: space-between;">
            <div>
                <h4>Customer Information</h4>
                <p><strong>Name:</strong> {{ $order->customer->first_name }} {{ $order->customer->last_name }}</p>
                <p><strong>Email:</strong> {{ $order->customer->email }}</p>
                <p><strong>Address:</strong> {{ $order->customer->address }}</p>
            </div>
            <div style="text-align: right;">
                <h4>Order Details</h4>
                <p><strong>Order ID:</strong> {{ $order->id }}</p>
                <p><strong>Date:</strong> {{ $order->created_at ? $order->created_at->format('d/m/Y') : 'N/A' }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            </div>
        </div>

        <!-- Order Item Table -->
        <div class="table-responsive">
            <table class="table" style="margin-top: 20px; border-collapse: collapse;">
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
                            Grand Total
                        </td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${{ number_format($order->total_price, 2) }}</td>
                    </tr>
                </tfoot>
            </table> 
        </div>


        <!-- Payment Status -->
        <div style="margin-top: 20px;">
            @if ($order->payment_status == 'paid')
                <p><strong>Payment Status:</strong> Paid</p>
            @else
                <p><strong>Payment Status:</strong> Unpaid</p>
            @endif
        </div>

        <!-- Print and Download Buttons -->
        <div class="text-center" style="margin-top: 30px;">
            <button onclick="window.print();" class="btn btn-primary btn-sm">Print Invoice</button>
            <button onclick="downloadInvoicePDF()" class="btn btn-secondary btn-sm">Download PDF</button>
            <a href="{{ route('orders.index') }}" class="btn btn-danger btn-sm">Back to Orders</a>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script>
        function downloadInvoicePDF() {
            const invoice = document.getElementById("invoice");
            const options = {
                margin: 0.5,
                filename: 'invoice_{{ $order->id }}.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'letter',
                    orientation: 'portrait'
                }
            };
            html2pdf().set(options).from(invoice).save();
        }
    </script>
@endsection
