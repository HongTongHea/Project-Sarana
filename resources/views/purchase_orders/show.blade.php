<div class="modal fade" id="showModal{{ $purchaseOrder->id }}" tabindex="-1" aria-labelledby="showModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="text-uppercase mt-3 ms-1 text-black" style="font-weight: 700; font-size: 16px">
                        Purchase Order Details
                    </h6>
                </div>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- Purchase Order Header Information -->
                <div class="card border-0 bg-light-subtle mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="small text-muted d-block mb-1">Order ID</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-hashtag text-primary me-2"></i>
                                    <span class="fw-medium">{{ $purchaseOrder->id }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted d-block mb-1">Supplier</label>
                                <div>
                                    <i class="fas fa-truck text-primary me-2"></i>
                                    <span class="fw-medium">{{ $purchaseOrder->supplier->name }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted d-block mb-1">Order Date</label>
                                <div>
                                    <i class="fas fa-calendar text-primary me-2"></i>
                                    <span class="fw-medium">{{ $purchaseOrder->order_date->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="small text-muted d-block mb-1">Status</label>
                                <div>
                                    @php
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'received' => 'success',
                                            'cancelled' => 'danger',
                                        ];
                                        $statusColor = $statusColors[$purchaseOrder->status] ?? 'secondary';
                                    @endphp
                                    <i class="fas fa-circle text-{{ $statusColor }} me-2"></i>
                                    <span class="badge bg-{{ $statusColor }} text-capitalize">
                                        {{ $purchaseOrder->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="card border-0">
                    <div class="card-body">
                        <h6 class="text-dark mb-3 fw-semibold">
                            <i class="fas fa-list me-2"></i>Order Items
                        </h6>

                        @if ($purchaseOrder->items->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Item Type</th>
                                            <th>Item Name</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-end">Unit Price</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchaseOrder->items as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $item->item_type === 'App\Models\Product' || $item->item_type === 'App\Models\Accessory' ? 'primary' : 'secondary' }} text-white text-capitalize">
                                                        {{ class_basename($item->item_type) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($item->item)
                                                        {{ $item->item->name ?? 'N/A' }}
                                                    @else
                                                        <span class="text-muted">Item not found</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <span class="fw-bold">{{ number_format($item->quantity) }}</span>
                                                </td>
                                                <td class="text-end">
                                                    ${{ number_format($item->unit_price, 2) }}
                                                </td>
                                                <td class="text-end fw-bold">
                                                    ${{ number_format($item->total_price, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="border-top">
                                            <td colspan="5" class="text-end fw-bold">Grand Total:</td>
                                            <td class="text-end fw-bold fs-5 text-success">
                                                ${{ number_format($purchaseOrder->total_amount, 2) }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No items in this order</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light-subtle h-100">
                            <div class="card-body">
                                <h6 class="text-dark mb-3 fw-semibold">
                                    <i class="fas fa-user me-2"></i>Order Created By
                                </h6>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-medium">{{ $purchaseOrder->creator->name ?? 'Unknown' }}</p>
                                        <small class="text-muted">Employee ID: {{ $purchaseOrder->created_by }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($purchaseOrder->status === 'received' && $purchaseOrder->received_at)
                        <div class="col-md-6">
                            <div class="card border-0 bg-light-subtle h-100">
                                <div class="card-body">
                                    <h6 class="text-dark mb-3 fw-semibold">
                                        <i class="fas fa-check-circle me-2"></i>Received Information
                                    </h6>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar-check text-success me-3 fs-4"></i>
                                        <div>
                                            <p class="mb-0 fw-medium">Received on</p>
                                            <small
                                                class="text-muted">{{ $purchaseOrder->received_at->format('M d, Y') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>

                @if ($purchaseOrder->status === 'pending')
                    <form action="{{ route('purchase_orders.markAsReceived', $purchaseOrder) }}" method="POST"
                        class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm"
                            onclick="return confirm('Mark this order as received?')">
                            <i class="fas fa-check me-2"></i>Mark as Received
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
