<!-- Invoice Modal -->
<div class="modal fade" id="invoiceModal{{ $sale->id }}" tabindex="-1" aria-labelledby="invoiceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-bottom-0 py-3">
                <div class="d-flex align-items-center w-100">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                        style="width: 40px; height: 40px;">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="modal-title mb-0 text-dark fw-bold">INVOICE #{{ $sale->id }}</h5>
                        <small class="text-muted">Date {{ $sale->created_at->format('M d, Y') }}</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <div class="modal-body p-4">
                <div id="invoice-content-{{ $sale->id }}">
                    <!-- Company Header -->
                    <div class="text-center mb-4 pb-3 border-bottom">
                        <h2 class="mb-2 fw-bold">Angkor Tech Computer</h2>
                        <p class="text-muted mb-1">123 Street, Phnom Penh, Cambodia</p>
                        <p class="text-muted mb-0">Tel: +855 12 345 678 | Email: info@angkortech.com</p>
                    </div>

                    <!-- Info Cards -->
                    <div class="row g-3 mb-4">
                        <!-- Customer Info -->
                        <div class="col-md-6">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold mb-3">
                                        Customer Information
                                    </h6>
                                    <div class="mb-2">
                                        <small class="text-muted">Name:</small>
                                        <div class="fw-semibold">{{ $sale->customer->name ?? 'N/A' }}</div>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Email:</small>
                                        <div class="fw-semibold">{{ $sale->customer->email ?? 'N/A' }}</div>
                                    </div>
                                    <div>
                                        <small class="text-muted">Phone:</small>
                                        <div class="fw-semibold">{{ $sale->customer->phone ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sale Summary -->
                        <div class="col-md-6">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold mb-3">
                                        Sale Summary
                                    </h6>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <small class="text-muted">Items:</small>
                                            <div class="fw-semibold">{{ $sale->items->count() ?? 0 }}</div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Status:</small>
                                            <div><span class="badge bg-success">Completed</span></div>
                                        </div>
                                        <div class="col-12">
                                            <small class="text-muted">Payment:</small>
                                            <div class="fw-semibold">
                                                @if ($sale->payments->isNotEmpty())
                                                    @php $paymentMethod = $sale->payments->first()->method; @endphp
                                                    @switch($paymentMethod)
                                                        @case('cash')
                                                            <span class="badge bg-success">Cash</span>
                                                        @break

                                                        @case('aba')
                                                            <span class="badge bg-info">ABA Pay</span>
                                                        @break

                                                        @case('credit_card')
                                                            <span class="badge bg-warning">Credit Card</span>
                                                        @break

                                                        @default
                                                            <span class="badge bg-secondary">N/A</span>
                                                    @endswitch
                                                @else
                                                    <span class="badge bg-danger">Not Paid</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sale Items -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="mb-0 fw-bold">
                                Sale Details
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            @if ($sale->items && $sale->items->count())
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-3 border-0">#</th>
                                                <th class="border-0">Product/Accessory</th>
                                                <th class="text-end border-0">Qty</th>
                                                <th class="text-end border-0">Price</th>
                                                <th class="text-end pe-3 border-0">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $total = 0; @endphp
                                            @foreach ($sale->items as $index => $item)
                                                @php
                                                    $name = 'No Item';
                                                    if ($item->item_type === 'App\Models\Product' && $item->item) {
                                                        $name = $item->item->name;
                                                    } elseif (
                                                        $item->item_type === 'App\Models\Accessory' &&
                                                        $item->item
                                                    ) {
                                                        $name = $item->item->name;
                                                    }
                                                    $subtotal = $item->price * $item->quantity;
                                                    $total += $subtotal;
                                                @endphp
                                                <tr>
                                                    <td class="ps-3">{{ $index + 1 }}</td>
                                                    <td class="fw-medium">{{ $name }}</td>
                                                    <td class="text-end">{{ $item->quantity }}</td>
                                                    <td class="text-end">${{ number_format($item->price, 2) }}</td>
                                                    <td class="text-end pe-3 fw-semibold">
                                                        ${{ number_format($subtotal, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-shopping-cart text-muted mb-3" style="font-size: 2rem;"></i>
                                    <p class="text-muted mb-0">No items in this sale</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Totals -->
                    <div class="row justify-content-end">
                        <div class="col-lg-8 col-xl-6">
                            <div class="card border-0 bg-light">
                                <div class="card-body p-3">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <td class="fw-semibold">Subtotal</td>
                                                <td class="text-end">${{ number_format($sale->subtotal, 2) }}</td>
                                            </tr>
                                            @if ($sale->item_discounts > 0)
                                                <tr>
                                                    <td class="fw-semibold text-success">Item Discounts</td>
                                                    <td class="text-end text-success">
                                                        -${{ number_format($sale->item_discounts, 2) }}</td>
                                                </tr>
                                            @endif
                                            @if ($sale->additional_discount > 0)
                                                <tr>
                                                    <td class="fw-semibold text-success">Additional Discount</td>
                                                    <td class="text-end text-success">
                                                        -${{ number_format($sale->additional_discount, 2) }}</td>
                                                </tr>
                                            @endif
                                            @if ($sale->tax_amount > 0)
                                                <tr>
                                                    <td class="fw-semibold">Tax</td>
                                                    <td class="text-end">${{ number_format($sale->tax_amount, 2) }}
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr class="border-top">
                                                <td class="fw-bold fs-5">Total Amount</td>
                                                <td class="text-end fw-bold fs-5 ">
                                                    ${{ number_format($sale->total, 2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="text-center mt-5 pt-4 border-top">
                        <p class="text-muted mb-2">
                            <i class="fas fa-heart text-danger me-1"></i>Thank you for your business!
                        </p>
                        <p class="text-muted small mb-0">For any inquiries, please contact us at info@angkortech.com
                        </p>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-top-0 bg-light py-3">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary btn-sm" onclick="printInvoice('{{ $sale->id }}')">
                    <i class="fas fa-print me-2"></i>Print Invoice
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-lg {
        max-width: 900px;
    }

    #invoiceModal{{ $sale->id }} .modal-body {
        max-height: 70vh;
        overflow-y: auto;
    }

    .card {
        border-radius: 12px;
    }

    .table th {
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge {
        font-size: 0.75rem;
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
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
                @media print {
                    @page {
                        size: A4;
                        margin: 5mm;
                    }
                    body {
                        font-family: 'Poppins', sans-serif;
                        background: white !important;
                        color: #333 !important;
                        margin: 0;
                        padding: 0;
                        font-size: 14px;
                        line-height: 1.4;
                    }
                    .invoice-container {
                        width: 100%;
                        height: 100%;
                        background: white;
                        padding: 0;
                        margin: 0;
                    }
                    /* Match modal styling exactly */
                    .card {
                        border: none !important;
                        border-radius: 12px !important;
                        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
                        margin-bottom: 16px;
                        page-break-inside: avoid;
                    }
                    .bg-light {
                        background-color: #f8f9fa !important;
                    }
                    .table {
                        font-size: 14px;
                        margin-bottom: 0;
                    }
                    .table th {
                        font-weight: 600;
                        font-size: 0.875rem;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                        border-bottom: 2px solid #dee2e6;
                        background: #f8f9fa !important;
                    }
                    .table-hover tbody tr:hover {
                        background-color: rgba(0,0,0,.075);
                    }
                    .badge {
                        font-size: 0.75rem;
                    }
                    h2 { 
                        font-size: 28px; 
                        margin-bottom: 8px; 
                        font-weight: bold;
                        color: #333;
                    }
                    h5 { 
                        font-size: 18px; 
                        margin-bottom: 8px; 
                        font-weight: bold;
                    }
                    h6 { 
                        font-size: 16px; 
                        margin-bottom: 8px; 
                        font-weight: bold;
                    }
                    .text-muted {
                        color: #6c757d !important;
                    }
                    .text-center {
                        text-align: center;
                    }
                    .border-bottom {
                        border-bottom: 1px solid #dee2e6 !important;
                    }
                    .border-top {
                        border-top: 1px solid #dee2e6 !important;
                    }
                    /* Spacing adjustments for print */
                    .mb-4 { margin-bottom: 1.5rem !important; }
                    .mb-3 { margin-bottom: 1rem !important; }
                    .mb-2 { margin-bottom: 0.5rem !important; }
                    .mt-5 { margin-top: 3rem !important; }
                    .pt-4 { padding-top: 1.5rem !important; }
                    .py-3 { padding-top: 1rem !important; padding-bottom: 1rem !important; }
                    .py-2 { padding-top: 0.5rem !important; padding-bottom: 0.5rem !important; }
                    .p-4 { padding: 1.5rem !important; }
                    .p-3 { padding: 1rem !important; }
                    .p-0 { padding: 0 !important; }
                    
                    /* Hide elements not needed in print */
                    .btn, .modal-footer, .no-print, .btn-close,
                    .modal-header, .modal-body, .modal-content {
                        display: none !important;
                    }
                    
                    /* Ensure tables don't break across pages */
                    table {
                        page-break-inside: auto;
                    }
                    tr {
                        page-break-inside: avoid;
                        page-break-after: auto;
                    }
                    thead {
                        display: table-header-group;
                    }
                    tfoot {
                        display: table-footer-group;
                    }
                }
                
                /* Screen styling (preview) */
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    background: #f8f9fa;
                    padding: 2rem;
                    margin: 0;
                }
                .invoice-container {
                    max-width: 800px;
                    margin: 0 auto;
                    background: white;
                    padding: 2rem;
                    border-radius: 12px;
                    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
                }
                .card {
                    border-radius: 12px;
                    border: none;
                    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                }
                .table th {
                    font-weight: 600;
                    font-size: 0.875rem;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                    border-bottom: 2px solid #dee2e6;
                }
                .badge {
                    font-size: 0.75rem;
                }
                .bg-light {
                    background-color: #f8f9fa !important;
                }
            </style>
        </head>
        <body>
            <div class="invoice-container">
                ${printContent}
            </div>
            <script>
                window.addEventListener('load', function() {
                    // Add a small delay to ensure all styles are loaded
                    setTimeout(function() {
                        window.print();
                        setTimeout(function() {
                            window.close();
                        }, 500);
                    }, 100);
                });
                
                // Fallback print trigger
                setTimeout(function() {
                    window.print();
                    setTimeout(function() {
                        window.close();
                    }, 500);
                }, 1000);
            <\/script>
        </body>
        </html>
    `);

        printWindow.document.close();
    }
</script>
