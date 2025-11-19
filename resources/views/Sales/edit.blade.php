@extends('layouts.app')
@section('title', 'AngkorTech Computer | Edit Sale & Transaction')
@section('content')
    <div class="container-fluid mt-3">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <!-- Sale Column -->
            <div class="col-md-7 mb-3">
                <div class="card rounded-0 h-100 ">
                    <!-- Added h-100 here -->
                    <div class="card-body d-flex flex-column" style="height: 100vh;">
                        <!-- Changed to flex column layout -->
                        <form action="{{ route('sales.update', $sale->id) }}" method="POST" id="sale-form"
                            class="d-flex flex-column h-100">
                            <!-- Added flex classes -->
                            @csrf @method('PUT')
                            <div class="d-flex justify-content-start align-items-center">
                                <button type="button" class="btn btn-primary mb-3 btn-sm me-2" data-bs-toggle="modal"
                                    data-bs-target="#createModal">
                                    <i class="fas fa-plus"></i> New Customer
                                </button>
                                <a href="{{ route('sales.index') }}" class="btn btn-primary mb-3 btn-sm">
                                    <i class="fas fa-list"></i> Sale History</a>
                            </div>
                            <div class="row">
                                <div class="form-group mb-3 col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fa-solid fa-users-line"></i>
                                        </span>
                                        <select name="customer_id" id="customer_id" class="form-control" required>
                                            <option value="">Enter Customer Name</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mb-3 col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon2">
                                            <i class="fa-solid fa-user-tie"></i>
                                        </span>
                                        <select name="employee_id" id="employee_id" class="form-control" required>
                                            <option value="">Select Sales Person</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}"
                                                    {{ $sale->employee_id == $employee->id ? 'selected' : '' }}>
                                                    {{ $employee->name }} ({{ $employee->position }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive flex-grow-1" style="overflow-y: auto;">
                                <!-- Made table scrollable -->
                                <table class="table table-bordered" id="sale-items">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Item</th>
                                            <th>Price</th>
                                            <th>Discount</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                            <th>Stock</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Items will be added dynamically -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="additional_discount">Additional Discount ($)</label>
                                        <input type="number" name="additional_discount" id="additional_discount"
                                            class="form-control" value="{{ $sale->additional_discount }}" min="0"
                                            step="0.01">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tax_rate">Tax Rate (%)</label>
                                        <input type="number" name="tax_rate" id="tax_rate" class="form-control"
                                            value="{{ ($sale->tax_amount / ($sale->subtotal - $sale->item_discounts)) * 100 }}"
                                            min="0" max="100" step="0.01">
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <strong>Subtotal:</strong>
                                        <span id="subtotal">${{ number_format($sale->subtotal, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <strong>Item Discounts:</strong>
                                        <span id="item-discounts">${{ number_format($sale->item_discounts, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <strong>Additional Discount:</strong>
                                        <span
                                            id="additional-discount-display">${{ number_format($sale->additional_discount, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <strong>Tax:</strong>
                                        <span id="tax">${{ number_format($sale->tax_amount, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <strong>Total:</strong>
                                        <span id="total"
                                            class="font-weight-bold">${{ number_format($sale->total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="items" id="sale-items-data" value="[]">
                            <input type="hidden" name="item_types" id="sale-item-types" value="[]">
                            <div class="mt-auto pt-3">
                                <!-- Added mt-auto to push to bottom -->
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-danger me-2 btn-sm" id="clear-sale">Clear
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" id="submit-sale">Update
                                    </button>
                                    @include('Sales.payment')
                                    <!-- Include payment modal -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Product Selection Column -->
            <div class="col-md-5 mb-3">
                <div class="card rounded-0 h-100">
                    <div class="card-body p-2">
                        <ul class="nav nav-tabs" id="productTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="products-tab" data-bs-toggle="tab"
                                    data-bs-target="#products" type="button" role="tab">Products</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="accessories-tab" data-bs-toggle="tab"
                                    data-bs-target="#accessories" type="button" role="tab">Accessories</button>
                            </li>
                        </ul>
                        <div class="tab-content mt-3" id="productTabsContent">
                            <div class="tab-pane fade show active" id="products" role="tabpanel">
                                <div class="form-group mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </span>
                                        <input type="text" id="product-search" class="form-control"
                                            placeholder="Search products...">
                                    </div>
                                </div>

                                <div id="product-results" class="row g-2" style="max-height: 800px; overflow-y: auto;">
                                    @if ($products->count() > 0)
                                        @foreach ($products as $product)
                                            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                                <div class="card product-item h-100" data-id="{{ $product->id }}"
                                                    data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                                                    data-stock="{{ $product->stock_no }}"
                                                    data-barcode="{{ $product->barcode }}"
                                                    data-stock-quantity="{{ $product->stock_quantity }}"
                                                    data-picture-url="{{ $product->picture_url ? asset('storage/' . $product->picture_url) : '' }}"
                                                    data-original-stock="{{ $product->stock_quantity }}"
                                                    data-discount-percentage="{{ $product->discount_percentage }}"
                                                    data-type="product"
                                                    style="cursor: pointer; transition: all 0.3s ease; position: relative;">
                                                    <!-- Stock Badge - Top Left -->
                                                    <div class="stock-badge position-absolute top-0 start-0 m-1"
                                                        data-product-id="{{ $product->id }}">
                                                        @if ($product->stock_quantity > 10)
                                                            <span class="badge bg-success"
                                                                style="font-size: 0.65rem;">{{ $product->stock_quantity }}</span>
                                                        @elseif ($product->stock_quantity > 0)
                                                            <span class="badge bg-warning"
                                                                style="font-size: 0.65rem;">{{ $product->stock_quantity }}</span>
                                                        @else
                                                            <span class="badge bg-danger"
                                                                style="font-size: 0.65rem;">0</span>
                                                        @endif
                                                    </div>

                                                    <div class="card-body p-2">
                                                        <div class="text-center">
                                                            @if ($product->picture_url)
                                                                <img src="{{ asset('storage/' . $product->picture_url) }}"
                                                                    alt="{{ $product->name }}"
                                                                    class="img-fluid mb-2 rounded-0"
                                                                    style="height: 80px; width: 100%; object-fit: cover;">
                                                            @else
                                                                <div class="d-flex align-items-center justify-content-center bg-light mb-2"
                                                                    style="height: 80px;">
                                                                    <i class="fas fa-image fa-2x text-muted"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <h6 class="card-title mb-1 text-truncate"
                                                            title="{{ $product->name }}">
                                                            {{ $product->name }}
                                                        </h6>
                                                        <div
                                                            class="d-flex justify-content-between align-items-center mb-1">
                                                            <div>
                                                                @if ($product->discount_percentage > 0)
                                                                    <span class="text-danger text-decoration-line-through"
                                                                        style="font-size: 0.8rem;">
                                                                        ${{ number_format($product->price, 2) }}
                                                                    </span>
                                                                    <span class="text-success fw-bold ms-1"
                                                                        style="font-size: 0.8rem;">
                                                                        ${{ number_format($product->price * (1 - $product->discount_percentage / 100), 2) }}
                                                                    </span>
                                                                @else
                                                                    <span class="fw-bold" style="font-size: 0.8rem;">
                                                                        ${{ number_format($product->price, 2) }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            @if ($product->discount_percentage > 0)
                                                                <span
                                                                    class="badge bg-success stock-badge position-absolute top-0 end-0 m-1"
                                                                    style="font-size: 0.6rem;">
                                                                    {{ $product->discount_percentage }}% OFF
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12 text-center py-4">
                                            <p class="text-muted">No products found.</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Products Pagination -->
                                @if ($products->hasPages())
                                    <div class="mt-3">
                                        {{ $products->links() }}
                                    </div>
                                @endif
                            </div>

                            <div class="tab-pane fade" id="accessories" role="tabpanel">
                                <div class="form-group mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </span>
                                        <input type="text" id="accessory-search" class="form-control"
                                            placeholder="Search accessories...">
                                    </div>
                                </div>

                                <div id="accessory-results" class="row g-2" style="max-height: 800px; overflow-y: auto;">
                                    @if ($accessories->count() > 0)
                                        @foreach ($accessories as $accessory)
                                            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                                <div class="card accessory-item h-100" data-id="{{ $accessory->id }}"
                                                    data-name="{{ $accessory->name }}"
                                                    data-price="{{ $accessory->price }}"
                                                    data-stock-quantity="{{ $accessory->stock_quantity }}"
                                                    data-picture-url="{{ $accessory->picture_url ? asset('storage/' . $accessory->picture_url) : '' }}"
                                                    data-original-stock="{{ $accessory->stock_quantity }}"
                                                    data-discount-percentage="{{ $accessory->discount_percentage }}"
                                                    data-type="accessory"
                                                    style="cursor: pointer; transition: all 0.3s ease; position: relative;">
                                                    <!-- Stock Badge - Top Left -->
                                                    <div class="stock-badge position-absolute top-0 start-0 m-1"
                                                        data-accessory-id="{{ $accessory->id }}">
                                                        @if ($accessory->stock_quantity > 10)
                                                            <span class="badge bg-success"
                                                                style="font-size: 0.65rem;">{{ $accessory->stock_quantity }}</span>
                                                        @elseif ($accessory->stock_quantity > 0)
                                                            <span class="badge bg-warning"
                                                                style="font-size: 0.65rem;">{{ $accessory->stock_quantity }}</span>
                                                        @else
                                                            <span class="badge bg-danger"
                                                                style="font-size: 0.65rem;">0</span>
                                                        @endif
                                                    </div>

                                                    <div class="card-body p-2">
                                                        <div class="text-center">
                                                            @if ($accessory->picture_url)
                                                                <img src="{{ asset('storage/' . $accessory->picture_url) }}"
                                                                    alt="{{ $accessory->name }}"
                                                                    class="img-fluid mb-2 rounded-0"
                                                                    style="height: 80px; width: 100%; object-fit: cover;">
                                                            @else
                                                                <div class="d-flex align-items-center justify-content-center bg-light mb-2"
                                                                    style="height: 80px;">
                                                                    <i class="fas fa-image fa-2x text-muted"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <h6 class="card-title mb-1 text-truncate"
                                                            title="{{ $accessory->name }}">
                                                            {{ $accessory->name }}
                                                        </h6>
                                                        <div
                                                            class="d-flex justify-content-between align-items-center mb-1">
                                                            <div>
                                                                @if ($accessory->discount_percentage > 0)
                                                                    <span class="text-danger text-decoration-line-through"
                                                                        style="font-size: 0.8rem;">
                                                                        ${{ number_format($accessory->price, 2) }}
                                                                    </span>
                                                                    <span class="text-success fw-bold ms-1"
                                                                        style="font-size: 0.8rem;">
                                                                        ${{ number_format($accessory->price * (1 - $accessory->discount_percentage / 100), 2) }}
                                                                    </span>
                                                                @else
                                                                    <span class="fw-bold" style="font-size: 0.8rem;">
                                                                        ${{ number_format($accessory->price, 2) }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            @if ($accessory->discount_percentage > 0)
                                                                <span
                                                                    class="badge bg-success stock-badge position-absolute top-0 end-0 m-1"
                                                                    style="font-size: 0.6rem;">
                                                                    {{ $accessory->discount_percentage }}% OFF
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12 text-center py-4">
                                            <p class="text-muted">No accessories found.</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Accessories Pagination -->
                                @if ($accessories->hasPages())
                                    <div class="mt-3">
                                        {{ $accessories->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('Customers.create')
    <!-- Include customer creation modal -->

    <style>
        .product-item:hover,
        .accessory-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: 1px solid #dee2e6;
            position: relative;
        }

        .card-title {
            font-size: 0.8rem;
            font-weight: 600;
        }

        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Stock Badge Styles */
        .stock-badge {
            z-index: 1;
        }

        .stock-badge .badge {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Pagination Styles */
        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }

        .col-lg-3 {
            width: 25%;
            height: 25%;
        }
    </style>

    <script>
        let saleItems = [];
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize with existing sale items
            @foreach ($sale->items as $item)
                @php
                    $itemType = $item->item_type === 'App\Models\Product' ? 'product' : 'accessory';

                    // Check if item still exists in database
                    if ($itemType === 'product') {
                        $itemModel = $item->product;
                    } else {
                        $itemModel = $item->accessory;
                    }

                    // Use data from sale item (not current database)
                    $itemName = addslashes($item->name);
                    $stockNo = $item->stock_no ?? '';
                    $stockQuantity = $itemModel ? $itemModel->stock_quantity : 0;
                    $pictureUrl = $itemModel && $itemModel->picture_url ? asset('storage/' . $itemModel->picture_url) : '';
                    $discountPercentage = $item->discount_percentage;
                @endphp

                saleItems.push({
                    type: '{{ $itemType }}',
                    item_id: {{ $item->item_id }},
                    name: '{{ $itemName }}',
                    stock_no: '{{ $stockNo }}',
                    price: {{ $item->price }},
                    discountedPrice: {{ $item->discounted_price }},
                    discountPercentage: {{ $discountPercentage }},
                    quantity: {{ $item->quantity }},
                    total: {{ $item->total }},
                    currentStock: {{ $stockQuantity }},
                    originalStock: {{ $stockQuantity + $item->quantity }},
                    picture_url: '{{ $pictureUrl }}',
                    existsInDb: {{ $itemModel ? 'true' : 'false' }}
                });
            @endforeach

            updateSaleTable();
            calculateTotals();

            // Product search functionality
            $('#product-search').on('input', function() {
                const search = $(this).val().toLowerCase();
                $('.product-item').each(function() {
                    const name = $(this).data('name').toString().toLowerCase();
                    const barcode = $(this).data('barcode').toString().toLowerCase();
                    $(this).closest('.col-lg-3').toggle(name.includes(search) || barcode.includes(
                        search));
                });
            });

            // Accessory search functionality
            $('#accessory-search').on('input', function() {
                const search = $(this).val().toLowerCase();
                $('.accessory-item').each(function() {
                    const name = $(this).data('name').toString().toLowerCase();
                    $(this).closest('.col-lg-3').toggle(name.includes(search));
                });
            });

            $('#submit-sale').on('click', function(e) {
                e.preventDefault();
                if (saleItems.length === 0) {
                    alert('Please add items to the sale');
                    return;
                }

                // Validate stock before proceeding
                let outOfStockItems = [];
                saleItems.forEach(item => {
                    if (item.quantity > item.originalStock) {
                        outOfStockItems.push(
                            `${item.name} (Requested: ${item.quantity}, Available: ${item.originalStock})`
                        );
                    }
                });

                if (outOfStockItems.length > 0) {
                    alert(`The following items don't have enough stock:\n\n${outOfStockItems.join('\n')}`);
                    return;
                }

                // Update the total amount in the modal
                const total = parseFloat($('#total').text().replace('$', ''));
                $('#modal-total-amount').text('$' + total.toFixed(2));

                // Show the modal
                $('#paymentModal').modal('show');
            });

            // Add product/accessory to sale
            $(document).on('click', '.product-item, .accessory-item', function(e) {
                e.preventDefault();
                const itemType = $(this).data('type');
                const itemId = $(this).data('id');
                const itemName = $(this).data('name');
                const itemPrice = parseFloat($(this).data('price'));
                const stockNo = $(this).data('stock') || '';
                const currentStock = parseInt($(this).data('stock-quantity'));
                const pictureUrl = $(this).data('picture-url');
                const originalStock = parseInt($(this).data('original-stock'));
                const discountPercentage = parseFloat($(this).data('discount-percentage')) || 0;

                // Calculate discounted price
                const discountedPrice = discountPercentage > 0 ? itemPrice * (1 - discountPercentage /
                    100) : itemPrice;

                // Check if item already exists in sale
                const existingItem = saleItems.find(item => item.item_id === itemId && item.type ===
                    itemType);
                const requestedQty = existingItem ? existingItem.quantity + 1 : 1;

                // Check stock availability
                if (currentStock < requestedQty) {
                    alert(`Not enough stock for ${itemName}. Available: ${currentStock}`);
                    return;
                }

                if (existingItem) {
                    existingItem.quantity += 1;
                    existingItem.total = existingItem.quantity * existingItem.discountedPrice;
                    existingItem.currentStock = currentStock - 1;
                } else {
                    saleItems.push({
                        type: itemType,
                        item_id: itemId,
                        name: itemName,
                        stock_no: stockNo,
                        price: itemPrice,
                        discountedPrice: discountedPrice,
                        discountPercentage: discountPercentage,
                        quantity: 1,
                        total: discountedPrice,
                        currentStock: currentStock - 1,
                        originalStock: originalStock,
                        picture_url: pictureUrl
                    });
                }

                // Update stock display
                updateStockDisplay(itemType, itemId, currentStock - 1);
                updateSaleTable();
                calculateTotals();
            });

            function updateStockDisplay(itemType, itemId, newStock) {
                const selector = itemType === 'product' ?
                    `.stock-badge[data-product-id="${itemId}"]` :
                    `.stock-badge[data-accessory-id="${itemId}"]`;

                const badge = $(selector);

                if (newStock > 10) {
                    badge.html(`<span class="badge bg-success" style="font-size: 0.65rem;">${newStock}</span>`);
                } else if (newStock > 0) {
                    badge.html(`<span class="badge bg-warning" style="font-size: 0.65rem;">${newStock}</span>`);
                } else {
                    badge.html(`<span class="badge bg-danger" style="font-size: 0.65rem;">0</span>`);
                }

                // Update the data attribute for the item
                const itemElement = itemType === 'product' ?
                    $(`.product-item[data-id="${itemId}"]`) :
                    $(`.accessory-item[data-id="${itemId}"]`);

                itemElement.data('stock-quantity', newStock);

                // Update any existing items in the sale table
                saleItems.forEach(item => {
                    if (item.item_id === itemId && item.type === itemType) {
                        item.currentStock = newStock;
                    }
                });

                // Disable item if out of stock
                if (newStock <= 0) {
                    itemElement.css('opacity', '0.6').css('cursor', 'not-allowed');
                } else {
                    itemElement.css('opacity', '1').css('cursor', 'pointer');
                }
            }

            function updateSaleTable() {
                const tbody = $('#sale-items tbody');
                tbody.empty();

                saleItems.forEach((item, index) => {
                    const imageHtml = item.picture_url ?
                        `<img src="${item.picture_url}" alt="${item.name}" class="img-thumbnail me-2 rounded-0" style="width: 70px; height: 70px; object-fit: cover;">` :
                        `<div class="img-thumbnail me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #f0f0f0;">
                <i class="fas fa-image text-muted"></i>
            </div>`;

                    const discountBadge = item.discountPercentage > 0 ?
                        `<span class="badge bg-success">${item.discountPercentage}% off</span>` : '';

                    const row = `
        <tr>
            <td>
                <div class="d-flex align-items-center">
                    ${imageHtml}
                    <div>
                        ${item.stock_no ? `<div><strong>${item.stock_no}</strong></div>` : ''}
                        <div>${item.name} ${discountBadge}</div>
                        <small class="text-muted">${item.type === 'product' ? 'Product' : 'Accessory'}</small>
                    </div>
                </div>
            </td>
            <td>
                $${item.price.toFixed(2)}
                ${item.discountPercentage > 0 ? `<br><span class="text-success">$${item.discountedPrice.toFixed(2)}</span>` : ''}
            </td>
            <td>${item.discountPercentage > 0 ? `${item.discountPercentage}%` : '0%'}</td>
            <td>
                <input type="number" class="form-control qty-input" data-index="${index}" value="${item.quantity}" min="1" ${item.existsInDb ? `max="${item.originalStock}"` : ''}>
            </td>
            <td>$${item.total.toFixed(2)}</td>
            <td>${item.existsInDb ? item.currentStock : 'N/A'}</td>
            <td>
                <button type="button" class="btn btn-sm btn-danger remove-item" data-index="${index}">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>`;

                    tbody.append(row);
                });


                // Add event listeners for quantity changes
                $('.qty-input').on('change', function() {
                    const index = $(this).data('index');
                    const newQty = parseInt($(this).val());
                    const item = saleItems[index];

                    if (newQty < 1) {
                        $(this).val(1);
                        return;
                    }

                    // Calculate the difference between new and old quantity
                    const qtyDifference = newQty - item.quantity;

                    // Check if we have enough stock
                    const availableStock = item.currentStock + item.quantity; // Original available stock

                    if (newQty > availableStock) {
                        alert(`Cannot order more than available stock: ${availableStock}`);
                        $(this).val(availableStock);
                        return;
                    }

                    // Update item properties
                    item.quantity = newQty;
                    item.total = newQty * item.discountedPrice;
                    item.currentStock = availableStock - newQty;

                    // Update stock display in product/accessory list
                    updateStockDisplay(item.type, item.item_id, item.currentStock);
                    updateSaleTable();
                    calculateTotals();
                });

                // Add event listeners for remove buttons
                $('.remove-item').on('click', function() {
                    const index = $(this).data('index');
                    const item = saleItems[index];

                    // Restore stock quantity in product/accessory list
                    const restoredStock = item.currentStock + item.quantity;
                    updateStockDisplay(item.type, item.item_id, restoredStock);

                    saleItems.splice(index, 1);
                    updateSaleTable();
                    calculateTotals();
                });
            }

            function calculateTotals() {
                const subtotal = saleItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                const discountedSubtotal = saleItems.reduce((sum, item) => sum + item.total, 0);
                const itemDiscounts = subtotal - discountedSubtotal;
                const taxRate = parseFloat($('#tax_rate').val()) || 0;
                const additionalDiscount = parseFloat($('#additional_discount').val()) || 0;
                const tax = discountedSubtotal * (taxRate / 100);
                const total = discountedSubtotal + tax - additionalDiscount;

                $('#subtotal').text(`$${subtotal.toFixed(2)}`);
                $('#item-discounts').text(`$${itemDiscounts.toFixed(2)}`);
                $('#additional-discount-display').text(`$${additionalDiscount.toFixed(2)}`);
                $('#tax').text(`$${tax.toFixed(2)}`);
                $('#total').text(`$${total.toFixed(2)}`);

                // Update hidden fields with sale data
                const formattedItems = saleItems.map(item => ({
                    type: item.type,
                    item_id: item.item_id,
                    quantity: item.quantity,
                    price: item.price,
                    discount_percentage: item.discountPercentage
                }));

                $('#sale-items-data').val(JSON.stringify(formattedItems));
                $('#sale-item-types').val(JSON.stringify(saleItems.map(item => item.type)));
            }

            // Clear sale
            $('#clear-sale').on('click', function() {
                // Restore all stock quantities
                saleItems.forEach(item => {
                    const restoredStock = item.currentStock + item.quantity;
                    updateStockDisplay(item.type, item.item_id, restoredStock);
                });

                saleItems = [];
                updateSaleTable();
                calculateTotals();
                $('#customer_id').val('');
                $('#additional_discount').val(0);
                $('#tax_rate').val(12);
            });

            // Recalculate when tax or discount changes
            $('#tax_rate, #additional_discount').on('change', calculateTotals);

            // Handle payment form submission
            $('#payment-form').on('submit', function(e) {
                e.preventDefault();

                const formData = {
                    customer_id: $('#customer_id').val(),
                    employee_id: $('#employee_id').val(),
                    items: $('#sale-items-data').val(),
                    subtotal: parseFloat($('#subtotal').text().replace('$', '')),
                    item_discounts: parseFloat($('#item-discounts').text().replace('$', '')),
                    additional_discount: parseFloat($('#additional-discount-display').text().replace(
                        '$', '')),
                    tax_amount: parseFloat($('#tax').text().replace('$', '')),
                    total: parseFloat($('#total').text().replace('$', '')),
                    status: 'completed',
                    payment_status: $('input[name="payment_method"]:checked').val(),
                };

                $.ajax({
                    url: '{{ route('sales.update', $sale->id) }}',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#paymentModal').modal('hide');
                            alert('Sale updated successfully!');
                            // Redirect to sale details or invoice
                            window.location.href = '{{ route('sales.invoice', $sale->id) }}';
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>
@endsection
