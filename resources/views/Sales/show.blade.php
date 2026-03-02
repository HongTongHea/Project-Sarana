<!-- Invoice Modal -->
<div class="modal fade" id="invoiceModal{{ $sale->id }}" tabindex="-1" aria-labelledby="invoiceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header border-bottom py-3 px-4">
                <div class="d-flex align-items-center w-100">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                        style="width: 40px; height: 40px;">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="modal-title mb-0 fw-bold">Invoice #{{ $sale->id }}</h5>
                        <small class="text-muted">Date: {{ $sale->created_at->format('d M Y') }}</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <div class="modal-body p-4">
                <div id="invoice-content-{{ $sale->id }}">

                    <!-- Company Header -->
                    <div class="text-center mb-4 pb-3 border-bottom">
                        <h2 class="fw-bold mb-1" style="font-size:1.6rem;">Angkor Tech Computer</h2>
                        <p class="text-muted mb-1" style="font-size:0.85rem;">123 Street, Phnom Penh, Cambodia</p>
                        <p class="text-muted mb-0" style="font-size:0.85rem;">Tel: +855 12 345 678 | Email:
                            info@angkortech.com</p>
                    </div>

                    <!-- Invoice # and Date Row -->
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-semibold" style="font-size:0.9rem;">Invoice # {{ $sale->id }}</span>
                        <span class="text-muted" style="font-size:0.9rem;">Date:
                            {{ $sale->created_at->format('d M Y') }}</span>
                    </div>

                    <!-- Info Row -->
                    <div class="row g-3 mb-4">
                        <!-- Customer Info -->
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">Customer Information</h6>
                            <p class="mb-1" style="font-size:0.875rem;">Name: {{ $sale->customer->name ?? 'N/A' }}</p>
                            <p class="mb-1" style="font-size:0.875rem;">Email: {{ $sale->customer->email ?? 'N/A' }}
                            </p>
                            <p class="mb-0" style="font-size:0.875rem;">Phone: {{ $sale->customer->phone ?? 'N/A' }}
                            </p>
                        </div>

                        <!-- Sale Summary -->
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">Sale Summary</h6>
                            <p class="mb-1" style="font-size:0.875rem;">Items: {{ $sale->items->count() ?? 0 }}</p>
                            <p class="mb-1" style="font-size:0.875rem;">
                                Status: <span class="badge bg-success">Completed</span>
                            </p>
                            <p class="mb-0" style="font-size:0.875rem;">
                                Payment:
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
                                    <span class="text-danger">Not Paid</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Sale Details -->
                    <h6 class="fw-bold mb-2">Sale Details</h6>
                    <div class="mb-4">
                        @if ($sale->items && $sale->items->count())
                            <table class="table table-bordered mb-0" style="font-size:0.875rem;">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border" style="width:40px;">#</th>
                                        <th class="border">PRODUCT/ACCESSORY</th>
                                        <th class="border text-center" style="width:70px;">QTY</th>
                                        <th class="border text-end" style="width:110px;">PRICE</th>
                                        <th class="border text-end" style="width:110px;">SUBTOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sale->items as $index => $item)
                                        @php
                                            $name = 'No Item';
                                            if ($item->item_type === 'App\Models\Product' && $item->item) {
                                                $name = $item->item->name;
                                            } elseif ($item->item_type === 'App\Models\Accessory' && $item->item) {
                                                $name = $item->item->name;
                                            }
                                            $subtotal = $item->price * $item->quantity;
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $name }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">${{ number_format($item->price, 2) }}</td>
                                            <td class="text-end">${{ number_format($subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted text-center py-3">No items in this sale</p>
                        @endif
                    </div>

                    <!-- Totals Table -->
                    <div class="row justify-content-end mb-4">
                        <div class="col-md-12">
                            <table class="table table-bordered mb-0" style="font-size:0.875rem;">
                                <tbody>
                                    <tr>
                                        <td>Subtotal</td>
                                        <td class="text-end">${{ number_format($sale->subtotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Item Discounts</td>
                                        <td class="text-end {{ $sale->item_discounts > 0 ? 'text-success' : '' }}">
                                            {{ $sale->item_discounts > 0 ? '-' : '' }}${{ number_format($sale->item_discounts ?? 0, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Additional Discount</td>
                                        <td
                                            class="text-end {{ $sale->additional_discount > 0 ? 'text-success' : '' }}">
                                            {{ $sale->additional_discount > 0 ? '-' : '' }}${{ number_format($sale->additional_discount ?? 0, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tax</td>
                                        <td class="text-end">${{ number_format($sale->tax_amount ?? 0, 2) }}</td>
                                    </tr>
                                    <tr class="table-light">
                                        <td class="fw-bold">Total Amount</td>
                                        <td class="text-end fw-bold">${{ number_format($sale->total, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="text-center pt-3 border-top">
                        <p class="text-muted mb-1" style="font-size:0.85rem;">Thank you for your business!</p>
                        <p class="text-muted mb-0" style="font-size:0.8rem;">For any inquiries, please contact us at
                            info@angkortech.com</p>
                    </div>

                </div><!-- end invoice-content -->
            </div>

            <div class="modal-footer border-top py-3">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Close
                </button>
                <button type="button" class="btn btn-primary btn-sm" onclick="printInvoice('{{ $sale->id }}')">
                    <i class="fas fa-print me-1"></i>Print Invoice
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    #invoiceModal{{ $sale->id }} .modal-body {
        max-height: 75vh;
        overflow-y: auto;
    }

    .modal-lg {
        max-width: 860px;
    }
</style>

<script>
    function printInvoice(saleId) {
        const printContent = document.getElementById('invoice-content-' + saleId).innerHTML;
        const printWindow = window.open('', '_blank', 'width=900,height=700');
        printWindow.document.write(`
    <!DOCTYPE html>
    <html>
    <head>
        <title>Invoice #${saleId} - Angkor Tech Computer</title>
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

            /* Company Header */
            .text-center { text-align: center; }
            .border-bottom { border-bottom: 1px solid #dee2e6 !important; }
            .border-top { border-top: 1px solid #dee2e6 !important; }
            h2 { font-size: 22px; font-weight: 700; margin: 0 0 4px; }
            h6 { font-size: 13px; font-weight: 700; margin: 0 0 8px; }
            .text-muted { color: #6c757d; }
            .mb-1 { margin-bottom: 4px; }
            .mb-2 { margin-bottom: 8px; }
            .mb-3 { margin-bottom: 12px; }
            .mb-4 { margin-bottom: 20px; }
            .pb-3 { padding-bottom: 12px; }
            .pt-3 { padding-top: 12px; }
            .p-0 { padding: 0; }

            /* Row / Grid */
            .d-flex { display: flex; }
            .justify-content-between { justify-content: space-between; }
            .row { display: flex; flex-wrap: wrap; margin: 0 -8px; }
            .col-md-6 { width: 50%; padding: 0 8px; }
            .row.justify-content-end { justify-content: flex-end; }
            .col-md-8 { width: 66.666%; padding: 0 8px; }

            /* Badge */
            .badge {
                display: inline-block;
                padding: 2px 8px;
                border-radius: 4px;
                font-size: 11px;
                font-weight: 600;
                color: white;
            }
            .bg-success { background-color: #198754; }
            .text-danger { color: #dc3545; }
            .text-success { color: #198754; }

            /* Table */
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
            .text-end { text-align: right; }
            .text-center { text-align: center; }
            .fw-bold { font-weight: 700; }
            .fw-semibold { font-weight: 600; }
            tr.table-light td { background: #f8f9fa; }

            /* Footer */
            .footer-note { font-size: 12px; color: #6c757d; }

            @page {
                size: A4;
                margin: 12mm;
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
            window.addEventListener('load', function() {
                setTimeout(function() {
                    window.print();
                    setTimeout(function() { window.close(); }, 500);
                }, 200);
            });
        <\/script>
    </body>
    </html>
    `);
        printWindow.document.close();
    }
</script>
