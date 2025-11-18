@extends('layouts.app')

@section('title', 'Angkor Tech Computer | Sale & Transaction')

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
            <div class="col-md-8 mb-3">
                <div class="card rounded-0 h-100"> <!-- Added h-100 here -->
                    <div class="card-body d-flex flex-column" style="height: 100vh;">
                        <!-- Changed to flex column layout -->
                        <form action="{{ route('sales.store') }}" method="POST" id="sale-form"
                            class="d-flex flex-column h-100"> <!-- Added flex classes -->
                            @csrf
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
                                                <option value="{{ $customer->id }}">
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
                                                <option value="{{ $employee->id }}">
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

                            <input type="hidden" name="items" id="sale-items-data" value="[]">
                            <input type="hidden" name="item_types" id="sale-item-types" value="[]">

                            <div class="mt-auto pt-3"> <!-- Added mt-auto to push to bottom -->
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-danger me-2 btn-sm" id="clear-sale">Clear
                                      </button>
                                    <button type="button" class="btn btn-primary btn-sm" id="submit-sale">Check Out</button>
                                    @include('Sales.payment') <!-- Include payment modal -->
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
                                            data-barcode="{{ $product->barcode }}"
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
                                                            <span class="badge bg-success ms-2">
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
    @include('Customers.create') <!-- Include customer creation modal -->

    <script>
        let saleItems = [];

        document.addEventListener('DOMContentLoaded', function() {
            // Product search functionality
            $('#product-search').on('input', function() {
                const search = $(this).val().toLowerCase(); // convert input to string
                $('.product-item').each(function() {
                    const name = $(this).data('name').toString().toLowerCase(); // ensure string
                    const barcode = $(this).data('barcode').toString()
                        .toLowerCase(); // convert number to string
                    $(this).toggle(name.includes(search) || barcode.includes(search));
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
                const discountedPrice = discountPercentage > 0 ?
                    itemPrice * (1 - discountPercentage / 100) :
                    itemPrice;

                // Check if item already exists in sale
                const existingItem = saleItems.find(item =>
                    item.item_id === itemId && item.type === itemType
                );

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
                badge.text(`Stock: ${newStock}`);

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
                        <td>${item.currentStock}</td>
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
            // Handle payment form submission
            $('#payment-form').on('submit', function(e) {
                e.preventDefault();

                const formData = {
                    customer_id: $('#customer_id').val(),
                    employee_id: $('#employee_id').val(), // Add this line
                    items: $('#sale-items-data').val(),
                    subtotal: parseFloat($('#subtotal').text().replace('$', '')),
                    // Remove item_discounts from here
                    additional_discount: parseFloat($('#additional-discount-display').text().replace(
                        '$', '')),
                    tax_amount: parseFloat($('#tax').text().replace('$', '')),
                    total: parseFloat($('#total').text().replace('$', '')),
                    status: 'completed', // Add status
                    payment_status: $('input[name="payment_method"]:checked').val(),
                };

                $.ajax({
                    url: '{{ route('sales.store') }}',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#paymentModal').modal('hide');
                            alert('Sale created successfully!');
                            // Reset the form
                            $('#clear-sale').click();
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
