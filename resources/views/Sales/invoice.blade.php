@extends('layouts.app')

@section('title', 'Invoice | POS System')

@section('content')
    <div class="container mt-5 mb-5" id="invoice-area" style="max-width: 800px;">
        <div class="card p-4 border-0 rounded-0 shadow-sm">
            <!-- Header -->
            <div class="text-center mb-4">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <div class="me-3"></div>
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
                    <h5 class="card-title  border-bottom pb-2"><strong>Customer Information</strong></h5>
                    <div class="row">
                        <div><strong>Name: {{ $sale->customer->name ?? 'N/A' }}</strong></div>
                    </div>
                    <div class="row">
                        <div><strong>Email: {{ $sale->customer->email ?? 'N/A' }}</strong></div>
                    </div>
                    <div class="row">
                        <div><strong>Phone: {{ $sale->customer->phone ?? 'N/A' }}</strong></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title border-bottom pb-2"><strong>Sale Summary</strong></h5>
                    <div class="row">
                        <div><strong>Items: {{ $sale->items->count() ?? 0 }}</strong></div>
                    </div>
                    <div class="row">
                        <div class="col-6"><strong>Status: <span class="badge bg-success">Completed</span></strong></div>
                    </div>
                    <div class="row">
                        <div class="col-6"><strong>Payment:
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
            <div class="mt-5 pt-4 border-top text-center text-muted">
                <p class="mb-1">Thank you for your business!</p>
                <p class="mb-0">For any inquiries, please contact us at info@angkortech.com</p>
            </div>

            <!-- Print Button -->
            <div class="text-center mt-4 no-print">
                <button onclick="printInvoice()" class="btn btn-primary px-4">
                    <i class="fas fa-print me-2"></i> Print Invoice
                </button>
                <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary px-4 ms-2">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
            </div>
        </div>
    </div>

    <!-- Print Script -->
    <script>
        function printInvoice() {
            let printContents = document.getElementById('invoice-area').innerHTML;
            let originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>

    <style>
        @media print {
            @page {
                size: 800px 800px;
                margin: 0;
            }

            html,
            body {
                width: 800px;
                height: 800px;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden;
            }

            body * {
                visibility: hidden;
            }

            #invoice-area,
            #invoice-area * {
                visibility: visible;
            }

            #invoice-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 800px;
                height: 800px;
                overflow: hidden;
            }

            .btn,
            .no-print,
            .navbar,
            .footer {
                display: none !important;
            }
        }
    </style>
@endsection
