@extends('website.app')
@section('content')
    <style>
        .sticky-top {
            position: sticky;
            z-index: 10;
        }

        #checkoutOrderItems {
            max-height: 400px;
            overflow-y: auto;
        }

        .cart-item-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }

        /* Telegram Modal Styles */

        .icon-order i {
            font-size: 40px;
            color: #ffffff;
            margin-bottom: 15px;
            border-radius: 50%;
            padding: 10px 20px;
            background-color: #0088cc;
        }

        .telegram-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 99999;
            align-items: center;
            justify-content: center;
        }

        .telegram-modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .telegram-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            display: block;
        }


        .telegram-note {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 0.9em;
        }

        .countdown-timer {
            font-size: 1.2em;
            font-weight: bold;
            color: #dc3545;
            text-align: center;
            margin: 10px 0;
        }
    </style>

    <!-- Toast Container for Notifications -->
    <div id="toastContainer" class="toast-container"></div>

    <!-- Telegram Confirmation Modal -->
    <div id="telegramModal" class="telegram-modal">
        <div class="telegram-modal-content">
            <button type="button" class="btn-close float-end" aria-label="Close" onclick="cancelOrder()"></button>
            <div class="d-flex justify-content-center align-items-center icon-order">
                <i class="bi bi-bag-check"></i>
            </div>

            <h3 class="text-center mb-2 fw-bold">Confirm Order with Telegram</h3>
            <p class="text-center">Click the button below to open Telegram with your order details pre-filled. Just hit send
                to confirm your order!</p>

            <div class="countdown-timer" id="countdownTimer">30</div>
            <div class=" d-flex justify-content-center mt-3">
                <button class="btn btn-primary me-2 fw-bold" onclick="confirmTelegramOrder()" id="telegramConfirmBtn">
                    <i class="fab fa-telegram"></i>
                    Confirm Order
                </button>
                <button class="btn btn-outline-danger fw-bold" onclick="cancelOrder()"><i
                        class="fas fa-times me-1"></i>Cancel Order</button>
            </div>
            <div class="telegram-note">
                <p><strong>Note:</strong> Your order will be processed only after sending the message on Telegram We will
                    contact back to you soon. Please
                    make sure to:</p>
                <ul class="mb-0">
                    <li>Have Telegram installed on your device</li>
                    <li>Be logged into your Telegram account</li>
                    <li>Send the pre-filled message when Telegram opens</li>
                </ul>
            </div>
            <div class="text-center mt-3">
                <st class="text-muted">Thank you for ordering!</small>
            </div>
        </div>
    </div>

    <!-- Checkout Page Content -->
    <div class="container" style="margin-top: 100px;">
        <div class="row">
            <div class="col-md-8">
                <h2 class="fw-bold">Checkout</h2>
                <form id="checkoutForm">
                    @csrf
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Customer Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_first_name" class="form-label">First Name *</label>
                                        <input type="text" class="form-control" id="customer_first_name"
                                            name="customer_first_name" value="{{ $user->first_name ?? '' }}" required>
                                        <div class="invalid-feedback">Please provide your first name.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_last_name" class="form-label">Last Name *</label>
                                        <input type="text" class="form-control" id="customer_last_name"
                                            name="customer_last_name" value="{{ $user->last_name ?? '' }}" required>
                                        <div class="invalid-feedback">Please provide your last name.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_email" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="customer_email" name="customer_email"
                                            value="{{ $user->email ?? '' }}" required>
                                        <div class="invalid-feedback">Please provide a valid email address.</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_phone" class="form-label">Phone Number *</label>
                                        <input type="tel" class="form-control" id="customer_phone" name="customer_phone"
                                            value="{{ $user->phone ?? '' }}" required>
                                        <div class="invalid-feedback">Please provide your phone number.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Shipping Address</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="shipping_address" class="form-label">Please Complete Real Shipping Address
                                    *</label>
                                <textarea class="form-control" id="shipping_address" name="shipping_address" rows="4" required
                                    placeholder="Street address, City, State, ZIP Code, Country">{{ $user->address ?? '' }}</textarea>
                                <div class="invalid-feedback">Please provide your shipping address.</div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Billing Address</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="same_as_shipping">
                                <label class="form-check-label" for="same_as_shipping">
                                    Same as shipping address
                                </label>
                            </div>
                            <div class="mb-3">
                                <label for="billing_address" class="form-label">Complete Billing Address *</label>
                                <textarea class="form-control" id="billing_address" name="billing_address" rows="4" required
                                    placeholder="Street address, City, State, ZIP Code, Country">{{ $user->address ?? '' }}</textarea>
                                <div class="invalid-feedback">Please provide your billing address.</div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Additional Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="customer_notes" class="form-label">Order Notes</label>
                                <textarea class="form-control" id="customer_notes" name="customer_notes" rows="3"
                                    placeholder="Any special instructions, delivery preferences, or notes..."></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-4">
                <div class="card sticky-top" style="top: 85px; margin-top: 45px;">
                    <div class="card-header">
                        <h5>Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div id="checkoutOrderItems">
                            <!-- Order items will be dynamically loaded here -->
                            <div class="text-center py-3">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2">Loading cart items...</p>
                            </div>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span id="checkoutSubtotal">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Discount:</span>
                            <span id="checkoutDiscount">-$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping provided <br>for Cambodia only in 25 provinces</span>
                            <span id="checkoutShipping">$0.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total:</span>
                            <span id="checkoutTotal">$0.00</span>
                        </div>

                        <button type="button" class="btn btn-primary w-100 mt-3 btn-md fw-bold" onclick="placeOrder()"
                            id="placeOrderBtn">
                            Place Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('website.shoppingcart')
    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome for icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <script>
        // Global variables
        let currentOrderData = null;
        let countdownInterval = null;
        let countdownSeconds = 30;
        let telegramMessage = '';

        // Toast function for notifications
        function showToast(message, type = "success") {
            const toastContainer = document.getElementById('toastContainer');
            if (!toastContainer) return;

            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-bg-${type} border-0 show mb-2`;
            toast.setAttribute('role', 'alert');
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;

            toastContainer.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Load cart summary on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadCartSummary();

            // Copy shipping address to billing address if checkbox is checked
            document.getElementById('same_as_shipping').addEventListener('change', function() {
                const billingAddress = document.getElementById('billing_address');
                if (this.checked) {
                    billingAddress.value = document.getElementById('shipping_address').value;
                } else {
                    billingAddress.value = '';
                }
            });
        });


        function loadCartSummary() {
            const cart = JSON.parse(localStorage.getItem("shoppingCart")) || [];

            const orderItemsContainer = document.getElementById('checkoutOrderItems');
            const subtotalElement = document.getElementById('checkoutSubtotal');
            const discountElement = document.getElementById('checkoutDiscount');
            const shippingElement = document.getElementById('checkoutShipping');
            const totalElement = document.getElementById('checkoutTotal');

            if (cart.length === 0) {
                orderItemsContainer.innerHTML = `
            <div class="text-center py-3">
                <i class="fas fa-shopping-cart fa-2x text-muted mb-2"></i>
                <p>Your cart is empty</p>
                <a href="/" class="btn btn-primary mt-2">Continue Shopping</a>
            </div>
        `;
                document.getElementById('placeOrderBtn').disabled = true;
                return;
            }

            let subtotal = 0; // ✅ FINAL item totals (after discount)
            let totalDiscount = 0; // ℹ️ informational only
            let html = '';

            cart.forEach((item, index) => {
                const originalPrice = item.price;
                const discountedPrice = item.discount ?
                    originalPrice * (1 - item.discount / 100) :
                    originalPrice;

                const itemTotal = discountedPrice * item.quantity;
                const originalTotal = originalPrice * item.quantity;
                const discountAmount = originalTotal - itemTotal;

                subtotal += itemTotal; // ✅ correct subtotal
                totalDiscount += discountAmount;

                html += `
            <div class="d-flex justify-content-between mb-3 pb-2 border-bottom">
                <div class="d-flex align-items-start">
                    <img src="${item.img}" class="cart-item-image me-3" alt="${item.name}">
                    <div>
                        <div class="fw-medium">${item.name}</div>
                        <small class="text-muted">Qty: ${item.quantity}</small>
                        ${item.discount ? `<br><small class="text-success">-${item.discount}% off</small>` : ''}
                    </div>
                </div>
                <div class="text-end">
                    <div class="fw-medium">$${itemTotal.toFixed(2)}</div>
                    ${item.discount
                        ? `<small class="text-muted text-decoration-line-through">$${originalTotal.toFixed(2)}</small>`
                        : ''}
                </div>
            </div>
        `;
            });

            const shipping = 5.00;
            const total = subtotal + shipping;

            // ✅ Update UI
            orderItemsContainer.innerHTML = html;
            subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
            discountElement.textContent = totalDiscount > 0 ?
                `-$${totalDiscount.toFixed(2)}` :
                '$0.00';
            shippingElement.textContent = `$${shipping.toFixed(2)}`;
            totalElement.textContent = `$${total.toFixed(2)}`;

            // ✅ Store for backend (matches UI exactly)
            window.cartTotals = {
                subtotal: subtotal,
                discount_amount: totalDiscount,
                shipping_amount: shipping,
                total_amount: total,
                items: cart
            };
        }

        function placeOrder() {
            const form = document.getElementById('checkoutForm');
            const cart = JSON.parse(localStorage.getItem("shoppingCart")) || [];

            // Basic validation
            const requiredFields = ['customer_first_name', 'customer_last_name', 'customer_email', 'customer_phone',
                'shipping_address',
                'billing_address'
            ];
            let isValid = true;

            requiredFields.forEach(field => {
                const element = document.getElementById(field);
                if (!element.value.trim()) {
                    element.classList.add('is-invalid');
                    isValid = false;
                } else {
                    element.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                showToast('Please fill in all required fields.', 'danger');
                return;
            }

            if (cart.length === 0) {
                showToast('Your cart is empty. Please add items to your cart before placing an order.', 'warning');
                return;
            }

            // Email validation
            const email = document.getElementById('customer_email').value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                document.getElementById('customer_email').classList.add('is-invalid');
                showToast('Please enter a valid email address.', 'danger');
                return;
            }

            // Prepare order data
            currentOrderData = {
                customer_first_name: document.getElementById('customer_first_name').value,
                customer_last_name: document.getElementById('customer_last_name').value,
                customer_email: document.getElementById('customer_email').value,
                customer_phone: document.getElementById('customer_phone').value,
                shipping_address: document.getElementById('shipping_address').value,
                billing_address: document.getElementById('billing_address').value,
                customer_notes: document.getElementById('customer_notes').value,
                cart_items: cart,
                subtotal: window.cartTotals?.subtotal || 0,
                discount_amount: window.cartTotals?.discount_amount || 0,
                shipping_amount: window.cartTotals?.shipping_amount || 0,
                total_amount: window.cartTotals?.total_amount || 0,
                payment_method: 'telegram_confirmation',
                order_date: new Date().toISOString()
            };

            // Generate order ID
            const orderId = 'ORD-' + Date.now() + '-' + Math.floor(Math.random() * 1000);
            currentOrderData.order_id = orderId;

            // Generate Telegram message using the contact-style format
            telegramMessage = formatOrderTelegramMessage(currentOrderData);

            // Show Telegram confirmation modal
            showTelegramModal();
        }

        function formatOrderTelegramMessage(orderData) {
            // Format similar to your contact page message
            let message = "🛒 Hello! I want to place an order through your website.\n\n";

            // Order Information
            message += "📋 Order Details:\n";
            message += "🆔 Order ID: " + orderData.order_id + "\n";
            message += "👤 Name: " + orderData.customer_first_name + " " + orderData.customer_last_name + "\n";
            message += "✉️ Email: " + orderData.customer_email + "\n";
            message += "📞 Phone: " + orderData.customer_phone + "\n\n";

            // Addresses
            message += "📍 Shipping Address:\n";
            message += orderData.shipping_address + "\n\n";

            message += "📋 Billing Address:\n";
            message += orderData.billing_address + "\n\n";

            // Order Items
            message += "📦 Order Items:\n";
            orderData.cart_items.forEach((item, index) => {
                const itemPrice = item.discount ?
                    item.price * (1 - item.discount / 100) :
                    item.price;
                const itemTotal = itemPrice * item.quantity;

                message += (index + 1) + ". " + item.name + "\n";
                message += "   Quantity: " + item.quantity + "\n";
                message += "   Price: $" + itemPrice.toFixed(2) + " each\n";
                if (item.discount) {
                    message += "   Discount: " + item.discount + "% OFF\n";
                }
                message += "   Subtotal: $" + itemTotal.toFixed(2) + "\n";
            });
            message += "\n";

            // Order Summary
            message += "💰 Order Summary:\n";
            message += "Subtotal: $" + orderData.subtotal.toFixed(2) + "\n";
            message += "Discount: -$" + orderData.discount_amount.toFixed(2) + "\n";
            message += "Shipping: $" + orderData.shipping_amount.toFixed(2) + "\n";
            message += "Total: $" + orderData.total_amount.toFixed(2) + "\n\n";

            // Customer Notes
            if (orderData.customer_notes && orderData.customer_notes.trim() !== '') {
                message += "💬 Additional Notes:\n";
                message += orderData.customer_notes + "\n\n";
            }

            // Footer
            message += "⏰ Order Date: " + new Date().toLocaleString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            }) + "\n\n";

            message += "✅ Please confirm if you can process this order. Thank you!";

            return message;
        }

        function showTelegramModal() {
            const modal = document.getElementById('telegramModal');
            modal.style.display = 'flex';

            // Reset countdown
            countdownSeconds = 30;
            document.getElementById('countdownTimer').textContent = countdownSeconds;

            // Start countdown
            countdownInterval = setInterval(() => {
                countdownSeconds--;
                document.getElementById('countdownTimer').textContent = countdownSeconds;

                if (countdownSeconds <= 0) {
                    clearInterval(countdownInterval);
                    cancelOrder();
                    showToast('Order confirmation timeout. Please try again.', 'warning');
                }
            }, 1000);
        }

        function hideTelegramModal() {
            const modal = document.getElementById('telegramModal');
            modal.style.display = 'none';

            if (countdownInterval) {
                clearInterval(countdownInterval);
                countdownInterval = null;
            }
        }

        function createTelegramDeepLink(message) {
            const username = 'Tonghear'; // Your Telegram username without @

            // URL encode the message
            const encodedMessage = encodeURIComponent(message);

            // Using the "text" parameter (most reliable for pre-filling message input)
            const telegramUrl = `https://t.me/${username}?text=${encodedMessage}`;

            console.log('Generated Telegram URL:', {
                username: username,
                message_length: message.length,
                url: telegramUrl
            });

            return telegramUrl;
        }

        function createTelegramShareLink(message) {
            const encodedMessage = encodeURIComponent(message);
            return `https://t.me/share/url?url=&text=${encodedMessage}`;
        }

        function confirmTelegramOrder() {
            // Disable the button to prevent double-clicks
            const telegramBtn = document.getElementById('telegramConfirmBtn');
            telegramBtn.disabled = true;
            telegramBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Opening Telegram...';

            // Create Telegram deep link with pre-filled message
            const telegramUrl = createTelegramDeepLink(telegramMessage);

            // Also create share link as fallback
            const shareLink = createTelegramShareLink(telegramMessage);

            // Try to open Telegram app first (using the deep link)
            window.open(telegramUrl, '_blank', 'noopener,noreferrer');

            // Check if Telegram app opened successfully
            setTimeout(() => {
                // If we're still on the page after 1 second, try the share link
                if (document.hasFocus()) {
                    window.open(shareLink, '_blank', 'noopener,noreferrer');
                    showToast('Opening Telegram in browser...', 'info');
                }
            }, 1000);

            // Submit the order to the server
            setTimeout(() => {
                submitOrder(currentOrderData);
            }, 1500);
        }

        function cancelOrder() {
            hideTelegramModal();
            currentOrderData = null;
            telegramMessage = '';
            showToast('Order cancelled.', 'info');

            // Reset Telegram button
            const telegramBtn = document.getElementById('telegramConfirmBtn');
            telegramBtn.disabled = false;
            telegramBtn.innerHTML = '<i class="fab fa-telegram"></i> Confirm Order';
        }

        function submitOrder(orderData) {
            const submitBtn = document.getElementById('placeOrderBtn');
            const originalText = submitBtn.innerHTML;

            // Show loading state
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Processing...';
            submitBtn.disabled = true;

            // Hide the modal
            hideTelegramModal();

            // Create FormData for submission
            const formData = new FormData();

            // Add all form fields
            formData.append('customer_first_name', orderData.customer_first_name);
            formData.append('customer_last_name', orderData.customer_last_name);
            formData.append('customer_email', orderData.customer_email);
            formData.append('customer_phone', orderData.customer_phone);
            formData.append('shipping_address', orderData.shipping_address);
            formData.append('billing_address', orderData.billing_address);
            formData.append('customer_notes', orderData.customer_notes || '');
            formData.append('payment_method', orderData.payment_method);
            formData.append('order_id', orderData.order_id);

            // Add cart and totals
            formData.append('cart_items', JSON.stringify(orderData.cart_items));
            formData.append('subtotal', orderData.subtotal);
            formData.append('discount_amount', orderData.discount_amount);
            formData.append('shipping_amount', orderData.shipping_amount);
            formData.append('total_amount', orderData.total_amount);
            formData.append('telegram_message', telegramMessage);
            formData.append('_token', '{{ csrf_token() }}');

            // Make actual AJAX request to the server
            fetch('{{ route('online-orders.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw err;
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showToast('Order placed successfully! Redirecting to confirmation...', 'success');

                        // Clear the cart from localStorage
                        localStorage.removeItem("shoppingCart");

                        // Redirect to confirmation page
                        setTimeout(() => {
                            if (data.redirect_url) {
                                window.location.href = data.redirect_url;
                            } else {
                                window.location.href = '/order-confirmation?order_id=' + orderData.order_id;
                            }
                        }, 2000);
                    } else {
                        throw new Error(data.error || 'Unknown error occurred');
                    }
                })
                .catch(error => {
                    console.error('Order submission error:', error);

                    let errorMessage = 'Failed to place order. Please try again.';

                    if (error.errors) {
                        // Validation errors - show first error
                        const firstError = Object.values(error.errors)[0][0];
                        errorMessage = firstError;

                        // Highlight problematic fields
                        Object.keys(error.errors).forEach(field => {
                            const element = document.getElementById(field);
                            if (element) {
                                element.classList.add('is-invalid');
                            }
                        });
                    } else if (error.error) {
                        errorMessage = error.error;
                    } else if (error.message) {
                        errorMessage = error.message;
                    }

                    showToast(errorMessage, 'danger');

                    // Reset button
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;

                    // Reset Telegram button
                    const telegramBtn = document.getElementById('telegramConfirmBtn');
                    telegramBtn.disabled = false;
                    telegramBtn.innerHTML = '<i class="fab fa-telegram"></i> Confirm Order';
                });
        }
    </script>
@endsection
