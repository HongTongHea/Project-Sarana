@extends('layouts.app')

@section('title', 'Angkor Tech Computer | POS System ')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container-fluid mt-3">
        <div class="row">
            <!-- Order Column -->
            <div class="col-md-8 mb-3">
                <div class="card rounded-0 h-100 "> <!-- Added h-100 here -->
                    <div class="card-body d-flex flex-column" style="height: 100vh;">
                        <!-- Changed to flex column layout -->
                        <form action="{{ route('orders.store') }}" method="POST" id="order-form"
                            class="d-flex flex-column h-100"> <!-- Added flex classes -->
                            @csrf

                            <div class="form-group mb-3">
                                <div class="input-group w-50">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fa-solid fa-users-line"></i>
                                    </span>
                                    <select name="customer_id" id="customer_id" class="form-control" required>
                                        <option value="">Enter Customer Name</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="table-responsive flex-grow-1" style="overflow-y: auto;">
                                <!-- Made table scrollable -->
                                <table class="table table-bordered" id="order-items">
                                    <thead>
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
                                            class="form-control" value="0" min="0" step="0.01">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tax_rate">Tax Rate (%)</label>
                                        <input type="number" name="tax_rate" id="tax_rate" class="form-control"
                                            value="12" min="0" max="100" step="0.01">
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <strong>Subtotal:</strong>
                                        <span id="subtotal">$0.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <strong>Item Discounts:</strong>
                                        <span id="item-discounts">$0.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <strong>Additional Discount:</strong>
                                        <span id="additional-discount-display">$0.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <strong>Tax:</strong>
                                        <span id="tax">$0.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <strong>Total:</strong>
                                        <span id="total" class="font-weight-bold">$0.00</span>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="items" id="order-items-data" value="[]">
                            <input type="hidden" name="item_types" id="order-item-types" value="[]">

                            <div class="mt-auto pt-3"> <!-- Added mt-auto to push to bottom -->
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-danger me-2" id="clear-order">Clear Order</button>
                                    <button type="submit" class="btn btn-primary" id="submit-order">Check Out</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Product Selection Column -->
            <div class="col-md-4 mb-3">
                <div class="card rounded-0 h-100">
                    <div class="card-body">
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

                                <div id="product-results" class="list-group"
                                    style="max-height: 800px; overflow-y: auto;">
                                    @foreach ($products as $product)
                                        <a href="#" class="list-group-item list-group-item-action product-item"
                                            data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                            data-price="{{ $product->price }}" data-stock="{{ $product->stock_no }}"
                                            data-stock-quantity="{{ $product->stock_quantity }}"
                                            data-picture-url="{{ $product->picture_url ? asset('storage/' . $product->picture_url) : '' }}"
                                            data-original-stock="{{ $product->stock_quantity }}"
                                            data-discount-percentage="{{ $product->discount_percentage }}"
                                            data-type="product">
                                            <div class="d-flex align-items-center">
                                                @if ($product->picture_url)
                                                    <img src="{{ asset('storage/' . $product->picture_url) }}"
                                                        alt="{{ $product->name }}" class="img-thumbnail me-3 rounded-0"
                                                        style="width: 60px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="img-thumbnail me-3 d-flex align-items-center justify-content-center"
                                                        style="width: 60px; height: 60px; background: #f0f0f0;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between">
                                                        <div>Name: {{ $product->name }}</div>
                                                        <strong>{{ $product->stock_no }}</strong>
                                                        @if ($product->discount_percentage > 0)
                                                            <span class="badge bg-success">
                                                                {{ $product->discount_percentage }}% off</span>
                                                        @endif
                                                    </div>
                                                    <span>Price: ${{ number_format($product->price, 2) }}</span><br>
                                                    <span>
                                                        @if ($product->discount_percentage > 0)
                                                            <span class="text-success">Discounted:
                                                                ${{ number_format($product->price * (1 - $product->discount_percentage / 100), 2) }}</span>
                                                        @endif
                                                    </span>

                                                    <br>
                                                    <div class="badge bg-info mt-1 stock-badge"
                                                        data-product-id="{{ $product->id }}">
                                                        Stock: {{ $product->stock_quantity }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
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

                                <div id="accessory-results" class="list-group"
                                    style="max-height: 800px; overflow-y: auto;">
                                    @foreach ($accessories as $accessory)
                                        <a href="#" class="list-group-item list-group-item-action accessory-item"
                                            data-id="{{ $accessory->id }}" data-name="{{ $accessory->name }}"
                                            data-price="{{ $accessory->price }}"
                                            data-stock-quantity="{{ $accessory->stock_quantity }}"
                                            data-picture-url="{{ $accessory->picture_url ? asset('storage/' . $accessory->picture_url) : '' }}"
                                            data-original-stock="{{ $accessory->stock_quantity }}"
                                            data-discount-percentage="{{ $accessory->discount_percentage }}"
                                            data-type="accessory">
                                            <div class="d-flex align-items-center">
                                                @if ($accessory->picture_url)
                                                    <img src="{{ asset('storage/' . $accessory->picture_url) }}"
                                                        alt="{{ $accessory->name }}" class="img-thumbnail me-3 rounded-0"
                                                        style="width: 60px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="img-thumbnail me-3 d-flex align-items-center justify-content-center"
                                                        style="width: 60px; height: 60px; background: #f0f0f0;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between">
                                                        <div>Name: {{ $accessory->name }}</div>
                                                        @if ($accessory->discount_percentage > 0)
                                                            <span class="badge bg-success">
                                                                {{ $accessory->discount_percentage }}% off</span>
                                                        @endif
                                                    </div>
                                                    <span>Price: ${{ number_format($accessory->price, 2) }}</span><br>
                                                    @if ($accessory->discount_percentage > 0)
                                                        <span class="text-success">Discounted:
                                                            ${{ number_format($accessory->price * (1 - $accessory->discount_percentage / 100), 2) }}</span>
                                                    @endif
                                                    <br>
                                                    <div class="badge bg-info mt-1 stock-badge"
                                                        data-accessory-id="{{ $accessory->id }}">
                                                        Stock: {{ $accessory->stock_quantity }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Product search functionality
            $('#product-search').on('input', function() {
                const search = $(this).val().toLowerCase();
                $('.product-item').each(function() {
                    const text = $(this).text().toLowerCase();
                    $(this).toggle(text.includes(search));
                });
            });

            // Accessory search functionality
            $('#accessory-search').on('input', function() {
                const search = $(this).val().toLowerCase();
                $('.accessory-item').each(function() {
                    const text = $(this).text().toLowerCase();
                    $(this).toggle(text.includes(search));
                });
            });

            // Add product/accessory to order
            let orderItems = [];

            $(document).on('click', '.product-item, .accessory-item', function(e) {
                e.preventDefault();

                const itemType = $(this).data('type'); // 'product' or 'accessory'
                const itemId = $(this).data('id');
                const itemName = $(this).data('name');
                const itemPrice = parseFloat($(this).data('price'));
                const stockNo = $(this).data('stock') || ''; // Accessories might not have stock no
                const availableStock = parseInt($(this).data('stock-quantity'));
                const pictureUrl = $(this).data('picture-url');
                const originalStock = parseInt($(this).data('original-stock'));
                const discountPercentage = parseFloat($(this).data('discount-percentage')) || 0;

                // Calculate discounted price
                const discountedPrice = discountPercentage > 0 ?
                    itemPrice * (1 - discountPercentage / 100) :
                    itemPrice;

                // Check if item already exists in order
                const existingItem = orderItems.find(item =>
                    item.item_id === itemId && item.type === itemType
                );

                const requestedQty = existingItem ? existingItem.quantity + 1 : 1;

                // Check stock availability
                if (availableStock <= 0) {
                    alert(`Not enough stock for ${itemName}. Available: 0`);
                    return;
                }

                if (existingItem) {
                    existingItem.quantity += 1;
                    existingItem.total = existingItem.quantity * existingItem.discountedPrice;
                    existingItem.availableStock = originalStock - existingItem.quantity;
                } else {
                    orderItems.push({
                        type: itemType,
                        item_id: itemId,
                        name: itemName,
                        stock_no: stockNo,
                        price: itemPrice,
                        discountedPrice: discountedPrice,
                        discountPercentage: discountPercentage,
                        quantity: 1,
                        total: discountedPrice,
                        availableStock: originalStock - 1,
                        picture_url: pictureUrl,
                        originalStock: originalStock
                    });
                }

                // Update stock display (subtract 1)
                const newStock = originalStock - (existingItem ? existingItem.quantity : 1);
                updateStockDisplay(itemType, itemId, newStock);

                updateOrderTable();
                calculateTotals();
            });

            // Update stock display in product/accessory list
            function updateStockDisplay(itemType, itemId, newStock) {
                const selector = itemType === 'product' ?
                    `.stock-badge[data-product-id="${itemId}"]` :
                    `.stock-badge[data-accessory-id="${itemId}"]`;

                const badge = $(selector);
                badge.text(`Stock: ${newStock}`);

                // Update the data attribute for the item
                const itemElement = itemType === 'product' ?
                    $(`.product-item[data-id="${itemId}"]`) :
                    $(`.accessory-item[data-id="${itemId}"]`);

                itemElement.data('stock-quantity', newStock);

                // Change badge color if stock is low
                if (newStock <= 0) {
                    badge.removeClass('bg-info').addClass('bg-danger');
                    itemElement.addClass('disabled').css('opacity', '0.6');
                } else if (newStock <= 5) {
                    badge.removeClass('bg-info').addClass('bg-warning');
                    itemElement.removeClass('disabled').css('opacity', '1');
                } else {
                    badge.removeClass('bg-danger bg-warning').addClass('bg-info');
                    itemElement.removeClass('disabled').css('opacity', '1');
                }
            }

            // Update order table with images
            function updateOrderTable() {
                const tbody = $('#order-items tbody');
                tbody.empty();

                orderItems.forEach((item, index) => {
                    const imageHtml = item.picture_url ?
                        `<img src="${item.picture_url}" alt="${item.name}" class="img-thumbnail me-2 rounded-0" style="width: 70px; height: 70px; object-fit: cover;">` :
                        `<div class="img-thumbnail me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #f0f0f0;">
                              <i class="fas fa-image text-muted"></i>
                           </div>`;

                    const discountBadge = item.discountPercentage > 0 ?
                        `<span class="badge bg-success">${item.discountPercentage}% off</span>` :
                        '';

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
                                <input type="number" class="form-control qty-input" 
                                       data-index="${index}" 
                                       value="${item.quantity}" min="1" max="${item.originalStock}">
                            </td>
                            <td>$${item.total.toFixed(2)}</td>
                            <td>${item.availableStock}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger remove-item" 
                                        data-index="${index}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tbody.append(row);
                });

                // Add event listeners for quantity changes
                $('.qty-input').on('change', function() {
                    const index = $(this).data('index');
                    const newQty = parseInt($(this).val());
                    const maxQty = parseInt($(this).attr('max'));

                    if (newQty < 1) {
                        $(this).val(1);
                        return;
                    }

                    if (newQty > maxQty) {
                        alert(`Cannot order more than original stock: ${maxQty}`);
                        $(this).val(maxQty);
                        return;
                    }

                    const item = orderItems[index];
                    const oldQty = item.quantity;

                    // Calculate the difference
                    const qtyDifference = newQty - oldQty;

                    // Update item properties
                    item.quantity = newQty;
                    item.total = newQty * item.discountedPrice;
                    item.availableStock = item.originalStock - newQty;

                    // Update stock display in product/accessory list
                    const newStock = item.originalStock - newQty;
                    updateStockDisplay(item.type, item.item_id, newStock);

                    updateOrderTable();
                    calculateTotals();
                });

                // Add event listeners for remove buttons
                $('.remove-item').on('click', function() {
                    const index = $(this).data('index');
                    const item = orderItems[index];

                    // Restore stock quantity in product/accessory list
                    const restoredStock = item.originalStock;
                    updateStockDisplay(item.type, item.item_id, restoredStock);

                    orderItems.splice(index, 1);
                    updateOrderTable();
                    calculateTotals();
                });
            }

            // Calculate totals
            function calculateTotals() {
                const subtotal = orderItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                const discountedSubtotal = orderItems.reduce((sum, item) => sum + item.total, 0);
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

                // Update hidden fields with order data
                const formattedItems = orderItems.map(item => ({
                    type: item.type,
                    item_id: item.item_id,
                    quantity: item.quantity,
                    price: item.price,
                    discount_percentage: item.discountPercentage
                }));

                $('#order-items-data').val(JSON.stringify(formattedItems));

                // Also store item types separately if needed
                const itemTypes = orderItems.map(item => item.type);
                $('#order-item-types').val(JSON.stringify(itemTypes));
            }

            // Clear order
            $('#clear-order').on('click', function() {
                // Restore all stock quantities
                orderItems.forEach(item => {
                    updateStockDisplay(item.type, item.item_id, item.originalStock);
                });

                orderItems = [];
                updateOrderTable();
                calculateTotals();
                $('#customer_id').val('');
                $('#additional_discount').val(0);
                $('#tax_rate').val(12);
            });

            // Recalculate when tax or discount changes
            $('#tax_rate, #additional_discount').on('change', calculateTotals);

            // Handle form submission
            $('#order-form').on('submit', function(e) {
                if (orderItems.length === 0) {
                    e.preventDefault();
                    alert('Please add at least one item to the order');
                    return false;
                }

                return true;
            });
        });
    </script>
@endsection
