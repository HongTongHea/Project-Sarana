@extends('layouts.app')

@section('title', 'POS System')

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
            <div class="col-md-7">
                <div class="card rounded-0">
                    <div class="card-body">
                        <form action="{{ route('orders.store') }}" method="POST" id="order-form">
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
                                                {{ $customer->first_name }} {{ $customer->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="table-responsive">
                                <table class="table table-bordered" id="order-items">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Price</th>
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
                                        <label for="discount">Discount ($)</label>
                                        <input type="number" name="discount" id="discount" class="form-control"
                                            value="0" min="0" step="0.01">
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
                                        <strong>Tax:</strong>
                                        <span id="tax">$0.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <strong>Discount:</strong>
                                        <span id="discount-display">$0.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <strong>Total:</strong>
                                        <span id="total" class="font-weight-bold">$0.00</span>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="items" id="order-items-data" value="[]">

                            <div class="mt-3 d-flex justify-content-end">
                                <button type="button" class="btn btn-danger me-2" id="clear-order">Clear Order</button>
                                <button type="submit" class="btn btn-primary" id="submit-order">Complete Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Product Selection Column -->
            <div class="col-md-5">
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                                <input type="text" id="product-search" class="form-control"
                                    placeholder="Search products...">
                            </div>
                        </div>


                        <div id="product-results" class="list-group" style="max-height: 300px; overflow-y: auto;">
                            @foreach ($products as $product)
                                <a href="#" class="list-group-item list-group-item-action product-item"
                                    data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                    data-price="{{ $product->price }}" data-stock="{{ $product->stock_no }}"
                                    data-stock-quantity="{{ $product->stock_quantity }}"
                                    data-picture-url="{{ $product->picture_url ? asset('storage/' . $product->picture_url) : '' }}"
                                    data-original-stock="{{ $product->stock_quantity }}">
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
                                                <strong>{{ $product->stock_no }}</strong>
                                            </div>
                                            <div>Name: {{ $product->name }}</div>
                                            <span>Price: ${{ number_format($product->price, 2) }}</span><br>
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

            // Add product to order
            let orderItems = [];

            $('.product-item').on('click', function(e) {
                e.preventDefault();

                const productId = $(this).data('id');
                const productName = $(this).data('name');
                const productPrice = parseFloat($(this).data('price'));
                const stockNo = $(this).data('stock');
                const availableStock = parseInt($(this).data('stock-quantity'));
                const pictureUrl = $(this).data('picture-url');
                const originalStock = parseInt($(this).data('original-stock'));

                // Check if product already exists in order
                const existingItem = orderItems.find(item => item.product_id === productId);
                const requestedQty = existingItem ? existingItem.quantity + 1 : 1;

                // Check stock availability
                if (availableStock <= 0) {
                    alert(`Not enough stock for ${productName}. Available: 0`);
                    return;
                }

                if (existingItem) {
                    existingItem.quantity += 1;
                    existingItem.total = existingItem.quantity * existingItem.price;
                    existingItem.availableStock = originalStock - existingItem.quantity;
                } else {
                    orderItems.push({
                        product_id: productId,
                        name: productName,
                        stock_no: stockNo,
                        price: productPrice,
                        quantity: 1,
                        total: productPrice,
                        availableStock: originalStock - 1,
                        picture_url: pictureUrl,
                        originalStock: originalStock
                    });
                }

                // Update stock display (subtract 1)
                const newStock = originalStock - (existingItem ? existingItem.quantity : 1);
                updateStockDisplay(productId, newStock);

                updateOrderTable();
                calculateTotals();
            });

            // Update stock display in product list
            function updateStockDisplay(productId, newStock) {
                const badge = $(`.stock-badge[data-product-id="${productId}"]`);
                badge.text(`Stock: ${newStock}`);

                // Update the data attribute for the product item
                const productItem = $(`.product-item[data-id="${productId}"]`);
                productItem.data('stock-quantity', newStock);

                // Change badge color if stock is low
                if (newStock <= 0) {
                    badge.removeClass('bg-info').addClass('bg-danger');
                    productItem.addClass('disabled').css('opacity', '0.6');
                } else if (newStock <= 5) {
                    badge.removeClass('bg-info').addClass('bg-warning');
                    productItem.removeClass('disabled').css('opacity', '1');
                } else {
                    badge.removeClass('bg-danger bg-warning').addClass('bg-info');
                    productItem.removeClass('disabled').css('opacity', '1');
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

                    const row = `
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    ${imageHtml}
                                    <div>
                                        <div><strong>${item.stock_no}</strong></div>
                                        <div>${item.name}</div>
                                    </div>
                                </div>
                            </td>
                            <td>$${item.price.toFixed(2)}</td>
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
                    item.total = newQty * item.price;
                    item.availableStock = item.originalStock - newQty;

                    // Update stock display in product list
                    const newStock = item.originalStock - newQty;
                    updateStockDisplay(item.product_id, newStock);

                    updateOrderTable();
                    calculateTotals();
                });

                // Add event listeners for remove buttons
                $('.remove-item').on('click', function() {
                    const index = $(this).data('index');
                    const item = orderItems[index];

                    // Restore stock quantity in product list
                    const restoredStock = item.originalStock - item.quantity + item.quantity;
                    updateStockDisplay(item.product_id, restoredStock);

                    orderItems.splice(index, 1);
                    updateOrderTable();
                    calculateTotals();
                });
            }

            // Calculate totals
            function calculateTotals() {
                const subtotal = orderItems.reduce((sum, item) => sum + item.total, 0);
                const taxRate = parseFloat($('#tax_rate').val()) || 0;
                const discount = parseFloat($('#discount').val()) || 0;
                const tax = subtotal * (taxRate / 100);
                const total = subtotal + tax - discount;

                $('#subtotal').text(`$${subtotal.toFixed(2)}`);
                $('#tax').text(`$${tax.toFixed(2)}`);
                $('#discount-display').text(`$${discount.toFixed(2)}`);
                $('#total').text(`$${total.toFixed(2)}`);

                // Update hidden field with properly formatted items data
                const formattedItems = orderItems.map(item => ({
                    product_id: item.product_id,
                    quantity: item.quantity,
                    price: item.price
                }));
                $('#order-items-data').val(JSON.stringify(formattedItems));
            }

            // Clear order
            $('#clear-order').on('click', function() {
                // Restore all stock quantities
                orderItems.forEach(item => {
                    updateStockDisplay(item.product_id, item.originalStock);
                });

                orderItems = [];
                updateOrderTable();
                calculateTotals();
                $('#customer_id').val('');
                $('#discount').val(0);
                $('#tax_rate').val(12);
            });

            // Recalculate when tax or discount changes
            $('#tax_rate, #discount').on('change', calculateTotals);

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
