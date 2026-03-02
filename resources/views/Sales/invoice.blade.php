@extends('layouts.app')

@section('title', 'Invoice | POS System')

@section('content')
    <div class="container mt-5 mb-5" style="max-width: 800px;">
        <div class="card p-4 border-0 rounded-0 shadow-sm">

            <!-- Invoice Content (used for printing) -->
            <div id="invoice-content">
                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="d-flex justify-content-center align-items-center mb-3">
                        <div>
                            <h2 class="mb-0"><strong>Angkor Tech Computer</strong></h2>
                            <p class="text-muted mb-0">123 Street, Phnom Penh, Cambodia</p>
                            <p class="text-muted mb-0">Tel: +855 12 345 678 | Email: info@angkortech.com</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between border-top border-bottom py-2 mb-3">
                        <div class="text-start">
                            <p class="mb-0"><strong>Invoice #</strong> {{ $sale->id }}</p>
                        </div>
                        <div class="text-end">
                            <p class="mb-0"><strong>Date:</strong> {{ $sale->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="card-title border-bottom pb-2"><strong>Customer Information</strong></h5>
                        <div><strong>Name: {{ $sale->customer->name ?? 'N/A' }}</strong></div>
                        <div><strong>Email: {{ $sale->customer->email ?? 'N/A' }}</strong></div>
                        <div><strong>Phone: {{ $sale->customer->phone ?? 'N/A' }}</strong></div>
                    </div>
                    <div class="col-md-6">
                        <h5 class="card-title border-bottom pb-2"><strong>Sale Summary</strong></h5>
                        <div><strong>Items: {{ $sale->items->count() ?? 0 }}</strong></div>
                        <div><strong>Status: <span class="badge bg-success">Completed</span></strong></div>
                        <div><strong>Payment:
                                @if ($sale->payments->isNotEmpty())
                                    @php $paymentMethod = $sale->payments->first()->method; @endphp
                                    @switch($paymentMethod)
                                        @case('cash')
                                            Cash
                                        @break

                                        @case('aba')
                                            ABA Pay
                                        @break

                                        @case('credit_card')
                                            Credit Card
                                        @break

                                        @default
                                            N/A
                                    @endswitch
                                @else
                                    Not Paid
                                @endif
                            </strong></div>
                    </div>
                </div>

                <!-- Sale Items -->
                <div class="mb-4">
                    <h5 class="mb-3"><strong>Sale Details</strong></h5>
                    @if ($sale->items && $sale->items->count())
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">#</th>
                                        <th>Product/Accessory</th>
                                        <th class="text-end">Qty</th>
                                        <th class="text-end">Price</th>
                                        <th class="text-end pe-3">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach ($sale->items as $index => $item)
                                        @php
                                            $name = 'No Item';
                                            if ($item->item_type === 'App\Models\Product' && $item->item) {
                                                $name = $item->item->name;
                                            } elseif ($item->item_type === 'App\Models\Accessory' && $item->item) {
                                                $name = $item->item->name;
                                            }
                                            $subtotal = $item->price * $item->quantity;
                                            $total += $subtotal;
                                        @endphp
                                        <tr>
                                            <td class="ps-3">{{ $index + 1 }}</td>
                                            <td>{{ $name }}</td>
                                            <td class="text-end">{{ $item->quantity }}</td>
                                            <td class="text-end">${{ number_format($item->price, 2) }}</td>
                                            <td class="text-end pe-3">${{ number_format($subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">No items in this sale.</div>
                    @endif
                </div>

                <!-- Total -->
                <div class="row justify-content-end">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td><strong>Subtotal</strong></td>
                                    <td class="text-end">${{ number_format($sale->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Item Discounts</strong></td>
                                    <td class="text-end">${{ number_format($sale->item_discounts, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Additional Discount</strong></td>
                                    <td class="text-end">${{ number_format($sale->additional_discount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tax</strong></td>
                                    <td class="text-end">${{ number_format($sale->tax_amount, 2) }}</td>
                                </tr>
                                <tr class="table-active">
                                    <td><strong>Total Amount</strong></td>
                                    <td class="text-end"><strong>${{ number_format($sale->total, 2) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-2 pt-4 border-top text-center text-muted">
                    <p class="mb-1">Thank you for your business!</p>
                    <p class="mb-0">For any inquiries, please contact us at info@angkortech.com</p>
                </div>
            </div>
            <!-- End Invoice Content -->

            <!-- Print Buttons (not printed) -->
            <div class="text-center mt-4">
                <button onclick="printInvoice()" class="btn btn-primary px-4">
                    <i class="fas fa-print me-2"></i> Print Invoice
                </button>
                <a href="{{ route('sales.index') }}" class="btn btn-danger px-4 ms-2">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
            </div>

        </div>
    </div>

    <!-- Print Script -->
    <script>
        function printInvoice() {
            const printContent = document.getElementById('invoice-content').innerHTML;
            const printWindow = window.open('', '_blank', 'width=900,height=700');
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Invoice #{{ $sale->id }} - Angkor Tech Computer</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
                    <style>
                        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

                        * { box-sizing: border-box; }

                        body {
                            font-family: 'Inter', sans-serif;
                            background: white;
                            color: #1a1a1a;
                            margin: 0;
                            padding: 0;
                            font-size: 13px;
                            line-height: 1.5;
                        }

                        .invoice-container {
                            max-width: 760px;
                            margin: 0 auto;
                            padding: 32px;
                            background: white;
                        }

                        .text-center { text-align: center; }
                        .text-end { text-align: right; }
                        .text-muted { color: #6c757d; }
                        .border-bottom { border-bottom: 1px solid #dee2e6 !important; }
                        .border-top { border-top: 1px solid #dee2e6 !important; }

                        h2 { font-size: 22px; font-weight: 700; margin: 0 0 4px; }
                        h5 { font-size: 15px; font-weight: 700; margin: 0 0 8px; }

                        .mb-0 { margin-bottom: 0; }
                        .mb-1 { margin-bottom: 4px; }
                        .mb-2 { margin-bottom: 8px; }
                        .mb-3 { margin-bottom: 12px; }
                        .mb-4 { margin-bottom: 20px; }
                        .mt-2 { margin-top: 8px; }
                        .pb-2 { padding-bottom: 8px; }
                        .pt-4 { padding-top: 20px; }
                        .py-2 { padding-top: 8px; padding-bottom: 8px; }
                        .ps-3 { padding-left: 12px; }
                        .pe-3 { padding-right: 12px; }

                        .d-flex { display: flex; }
                        .justify-content-between { justify-content: space-between; }
                        .justify-content-center { justify-content: center; }
                        .align-items-center { align-items: center; }

                        .row { display: flex; flex-wrap: wrap; margin: 0 -8px; }
                        .col-md-6 { width: 50%; padding: 0 8px; }
                        .col-md-12 { width: 100%; padding: 0 8px; }

                        .badge {
                            display: inline-block;
                            padding: 2px 8px;
                            border-radius: 4px;
                            font-size: 11px;
                            font-weight: 600;
                            color: white;
                        }
                        .bg-success { background-color: #198754; }

                        table {
                            width: 100%;
                            border-collapse: collapse;
                            font-size: 13px;
                        }
                        th, td {
                            border: 1px solid #dee2e6;
                            padding: 7px 10px;
                        }
                        thead th {
                            background: #f8f9fa;
                            font-weight: 600;
                            font-size: 11px;
                            text-transform: uppercase;
                            letter-spacing: 0.4px;
                        }
                        .table-active td { background-color: #f8f9fa; }
                        .fw-bold { font-weight: 700; }

                        @page {
                            size: A4;
                            margin: 15mm;
                        }
                        @media print {
                            body { padding: 0; }
                            .invoice-container { padding: 0; max-width: 100%; }
                        }
                    </style>
                </head>
                <body>
                    <div class="invoice-container">
                        ${printContent}
                    </div>
                    <script>
                        window.addEventListener('load', function () {
                            setTimeout(function () {
                                window.print();
                                setTimeout(function () { window.close(); }, 500);
                            }, 300);
                        });
                    <\/script>
                </body>
                </html>
            `);
            printWindow.document.close();
        }
    </script>
@endsection
