<div class="modal fade" id="showModal{{ $order->id }}" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <div class="d-flex justify-content-center align-items-center">
                    <h5 class="text-uppercase mt-2 ms-1 text-dark" style="font-weight: 700;">
                        Order Details - {{ $order->order_number }}
                    </h5>
                </div>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Printable Content -->
                <div id="order-content-{{ $order->id }}">

                    <!-- Order Header Section -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $order->order_number }}</h6>
                                    <small class="text-muted">Placed on
                                        {{ $order->created_at->format('M d, Y') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="mb-2">
                                <span
                                    class="badge 
                                    {{ $order->status == 'completed' ? 'bg-success' : ($order->status == 'pending' ? 'bg-warning' : ($order->status == 'cancelled' ? 'bg-danger' : 'bg-info')) }} fs-6">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div>
                                <span
                                    class="badge 
                                    {{ $order->payment_status == 'paid' ? 'bg-success' : ($order->payment_status == 'pending' ? 'bg-warning' : 'bg-danger') }} fs-6">
                                    Payment: {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Customer Information -->
                        <div class="col-12 col-md-6 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h6 class="mb-0 fw-bold">Customer Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <h6 class="mb-1">{{ $order->customer_first_name }}
                                            {{ $order->customer_last_name }}</h6>
                                        <small class="text-muted">{{ $order->customer_email }}</small>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Phone:</small>
                                        <span class="fw-medium ms-1">{{ $order->customer_phone ?? 'N/A' }}</span>
                                    </div>
                                    @if ($order->user)
                                        <div class="mb-2">
                                            <small class="text-muted">Account:</small>
                                            <span class="badge bg-info ms-1">{{ ucfirst($order->user->role) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="col-12 col-md-6 mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h6 class="mb-0 fw-bold">Order Summary</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Subtotal:</span>
                                        <span class="fw-medium">${{ number_format($order->subtotal, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Shipping:</span>
                                        <span class="fw-medium">${{ number_format($order->shipping_amount, 2) }}</span>
                                    </div>
                                    @if ($order->discount_amount > 0)
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted">Discount:</span>
                                            <span
                                                class="fw-medium text-success">-${{ number_format($order->discount_amount, 2) }}</span>
                                        </div>
                                    @endif
                                    <hr>
                                    <div class="d-flex justify-content-between mb-0">
                                        <span class="fw-bold">Total:</span>
                                        <span class="fw-bold">${{ number_format($order->total_amount, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="row mb-4">
                        <div class="col-12 col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h6 class="mb-0 fw-bold">Shipping Address</h6>
                                </div>
                                <div class="card-body">
                                    @if ($order->shipping_address)
                                        <p class="mb-0 small">{{ nl2br(e($order->shipping_address)) }}</p>
                                    @else
                                        <p class="text-muted mb-0 small">No shipping address provided</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-white border-0">
                                    <h6 class="mb-0 fw-bold">Billing Address</h6>
                                </div>
                                <div class="card-body">
                                    @if ($order->billing_address)
                                        <p class="mb-0 small">{{ nl2br(e($order->billing_address)) }}</p>
                                    @else
                                        <p class="text-muted mb-0 small">Same as shipping address</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-0">
                                    <h6 class="mb-0 fw-bold">Order Items</h6>
                                </div>
                                <div class="card-body p-0">
                                    @if ($order->items && $order->items->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th class="border-0">Product</th>
                                                        <th class="border-0 text-center">Quantity</th>
                                                        <th class="border-0 text-end">Price</th>
                                                        <th class="border-0 text-end">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->items as $item)
                                                        <tr>
                                                            <td class="border-0">
                                                                <div class="d-flex align-items-center">
                                                                    @if ($item->item && $item->item->picture_url)
                                                                        <img src="{{ Storage::url($item->item->picture_url) }}"
                                                                            alt="{{ $item->item_name }}"
                                                                            class="rounded me-3"
                                                                            style="width: 60px; height: 60px; object-fit: cover;">
                                                                    @else
                                                                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center me-3"
                                                                            style="width: 60px; height: 60px;">
                                                                            <i class="fas fa-box text-white"
                                                                                style="font-size: 0.8rem;"></i>
                                                                        </div>
                                                                    @endif
                                                                    <div>
                                                                        <h6 class="mb-0 small">
                                                                            {{ $item->item_name ?? 'Product' }}</h6>
                                                                        @if ($item->discount_percentage > 0)
                                                                            <small class="text-success">Discount:
                                                                                {{ $item->discount_percentage }}%</small>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="border-0 text-center">{{ $item->quantity }}
                                                            </td>
                                                            <td class="border-0 text-end">
                                                                @if ($item->discount_percentage > 0)
                                                                    <div>
                                                                        <span
                                                                            class="text-decoration-line-through text-muted small">
                                                                            ${{ number_format($item->unit_price, 2) }}
                                                                        </span>
                                                                        <br>
                                                                        <span class="fw-bold text-danger">
                                                                            ${{ number_format($item->discounted_price, 2) }}
                                                                        </span>
                                                                    </div>
                                                                @else
                                                                    ${{ number_format($item->unit_price, 2) }}
                                                                @endif
                                                            </td>
                                                            <td class="border-0 text-end">
                                                                ${{ number_format($item->total_price, 2) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr class="table-light">
                                                        <td colspan="3" class="text-end fw-bold">Subtotal:</td>
                                                        <td class="text-end fw-bold">
                                                            ${{ number_format($order->subtotal, 2) }}</td>
                                                    </tr>
                                                    @if ($order->discount_amount > 0)
                                                        <tr class="table-light">
                                                            <td colspan="3" class="text-end fw-bold text-success">
                                                                Discount:</td>
                                                            <td class="text-end fw-bold text-success">
                                                                -${{ number_format($order->discount_amount, 2) }}</td>
                                                        </tr>
                                                    @endif
                                                    @if ($order->shipping_amount > 0)
                                                        <tr class="table-light">
                                                            <td colspan="3" class="text-end fw-bold">Shipping:</td>
                                                            <td class="text-end fw-bold">
                                                                ${{ number_format($order->shipping_amount, 2) }}</td>
                                                        </tr>
                                                    @endif
                                                    <tr class="table-light">
                                                        <td colspan="3" class="text-end fw-bold fs-6">Total:</td>
                                                        <td class="text-end fw-bold fs-6">
                                                            ${{ number_format($order->total_amount, 2) }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-shopping-cart text-muted mb-2"
                                                style="font-size: 2rem;"></i>
                                            <p class="text-muted mb-0">No items in this order</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Notes -->
                    @if ($order->customer_notes)
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-white border-0">
                                        <h6 class="mb-0 fw-bold">Customer Notes</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0 text-muted">{{ $order->customer_notes }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
                <!-- End Printable Content -->

            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i> Close
                </button>
                <button type="button" class="btn btn-primary btn-sm" onclick="printOrder({{ $order->id }})">
                    <i class="fas fa-print me-1"></i> Print Receipt
                </button>
                <form action="{{ route('online-orders.payment.update', $order->id) }}" method="POST"
                    class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="payment_status" value="paid">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-check me-1"></i> Process Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function printOrder(orderId) {
        const printContent = document.getElementById('order-content-' + orderId).innerHTML;
        const printWindow = window.open('', '_blank', 'width=900,height=700');
        printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Order Receipt - Angkor Tech Computer</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

                * { box-sizing: border-box; margin: 0; padding: 0; }

                body {
                    font-family: 'Inter', sans-serif;
                    background: white;
                    color: #1a1a1a;
                    font-size: 11px;
                    line-height: 1.3;
                }

                .print-container {
                    max-width: 760px;
                    margin: 0 auto;
                    padding: 16px;
                }

                /* Company Header */
                .company-header {
                    text-align: center;
                    border-bottom: 2px solid #dee2e6;
                    padding-bottom: 8px;
                    margin-bottom: 12px;
                }
                .company-header h2 { font-size: 16px; font-weight: 700; margin: 0 0 2px; }
                .company-header p { color: #6c757d; margin: 0; font-size: 10px; }

                /* Utilities */
                .text-center { text-align: center; }
                .text-end { text-align: right; }
                .text-muted { color: #6c757d; }
                .text-success { color: #198754; }
                .text-danger { color: #dc3545; }
                .fw-bold { font-weight: 700; }
                .fw-medium { font-weight: 500; }
                .small { font-size: 10px; }
                .fs-6 { font-size: 12px; }
                .text-decoration-line-through { text-decoration: line-through; }

                .mb-0 { margin-bottom: 0; }
                .mb-1 { margin-bottom: 2px; }
                .mb-2 { margin-bottom: 4px; }
                .mb-3 { margin-bottom: 6px; }
                .mb-4 { margin-bottom: 10px; }
                .mt-4 { margin-top: 10px; }
                .me-1 { margin-right: 4px; }
                .me-3 { margin-right: 8px; }
                .ms-1 { margin-left: 4px; }

                /* Badge */
                .badge {
                    display: inline-block;
                    padding: 2px 6px;
                    border-radius: 4px;
                    font-size: 10px;
                    font-weight: 600;
                    color: white;
                }
                .bg-success { background-color: #198754; }
                .bg-warning { background-color: #ffc107; color: #000 !important; }
                .bg-danger { background-color: #dc3545; }
                .bg-info { background-color: #0dcaf0; color: #000 !important; }

                /* Grid */
                .row { display: flex; flex-wrap: wrap; margin: 0 -6px; }
                .col-md-6 { width: 50%; padding: 0 6px; box-sizing: border-box; }
                .col-12 { width: 100%; padding: 0 6px; box-sizing: border-box; }
                .d-flex { display: flex; }
                .align-items-center { align-items: center; }
                .justify-content-between { justify-content: space-between; }
                .text-md-end { text-align: right; }
                .h-100 { height: 100%; }

                /* Card */
                .card { border: 1px solid #dee2e6; border-radius: 4px; margin-bottom: 8px; }
                .card-header { padding: 5px 10px; background: white; border-bottom: 1px solid #dee2e6; }
                .card-header h6 { margin: 0; font-size: 11px; font-weight: 700; }
                .card-body { padding: 8px 10px; }
                .card-body.p-0 { padding: 0; }

                /* Circle icon */
                .rounded-circle {
                    border-radius: 50%;
                    width: 30px;
                    height: 30px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background: #0d6efd;
                    color: white;
                    font-size: 11px;
                }
                .bg-secondary { background-color: #6c757d; }
                .rounded { border-radius: 4px; }

                /* Table */
                table { width: 100%; border-collapse: collapse; font-size: 11px; }
                th, td { border: 1px solid #dee2e6; padding: 4px 8px; }
                thead.table-dark th { background: #212529; color: white; font-size: 10px; text-transform: uppercase; letter-spacing: 0.4px; }
                .border-0 { border: none !important; }
                .table-light td { background-color: #f8f9fa; }

                /* Product image */
                img { object-fit: cover; border-radius: 4px; width: 40px !important; height: 40px !important; }

                hr { border: 0; border-top: 1px solid #dee2e6; margin: 6px 0; }

                /* Footer */
                .print-footer {
                    text-align: center;
                    margin-top: 10px;
                    padding-top: 8px;
                    border-top: 1px solid #dee2e6;
                    color: #6c757d;
                    font-size: 10px;
                }

                @page {
                    size: A4;
                    margin: 8mm;
                }
                @media print {
                    body { padding: 0; }
                    .print-container { padding: 0; max-width: 100%; }
                    * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                }
            </style>
        </head>
        <body>
            <div class="print-container">
                <!-- Company Header -->
                <div class="company-header">
                    <h2>Angkor Tech Computer</h2>
                    <p>123 Street, Phnom Penh, Cambodia</p>
                    <p>Tel: +855 12 345 678 | Email: info@angkortech.com</p>
                </div>

                ${printContent}

                <!-- Print Footer -->
                <div class="print-footer">
                    <p>Thank you for your order! For any inquiries, please contact us at info@angkortech.com</p>
                </div>
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
