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

        .payment-method-card {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-method-card:hover {
            border-color: #6c757d;
        }

        .payment-method-card.selected {
            border-color: #0d6efd;
            background-color: #f8f9fa;
        }

        .payment-method-card input[type="radio"] {
            margin-right: 10px;
        }

        .payment-method-details {
            display: none;
            margin-top: 15px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .payment-method-card.selected .payment-method-details {
            display: block;
        }

        .payment-icon {
            width: 40px;
            height: 40px;
            margin-right: 10px;
            object-fit: contain;
        }

        .payment-title {
            display: flex;
            align-items: center;
            font-weight: 600;
        }
    </style>

    <!-- Toast Container for Notifications -->
    <div id="toastContainer" class="toast-container"></div>

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
                                        <label for="customer_phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="customer_phone" name="customer_phone"
                                            value="{{ $user->phone ?? '' }}">
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
                                <label for="shipping_address" class="form-label">Complete Shipping Address *</label>
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

                    <!-- Payment Method Section -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Payment Method</h5>
                        </div>
                        <div class="card-body">
                            <div class="payment-method-card" id="aba-payment-card">
                                <div class="payment-title">
                                    <input type="radio" id="aba_payment" name="payment_method" value="aba" required>
                                    <img src="/images/aba-logo.png" alt="ABA Bank" class="payment-icon">
                                    <label for="aba_payment" class="form-check-label fw-bold">ABA Bank</label>
                                </div>
                                <div class="payment-method-details">
                                    <p>Pay securely with ABA Bank. You will be redirected to ABA's payment gateway to
                                        complete your transaction.</p>
                                    <div class="mb-3">
                                        <label for="aba_account_name" class="form-label">Account Name (Optional)</label>
                                        <input type="text" class="form-control" id="aba_account_name"
                                            name="aba_account_name" placeholder="Enter account name">
                                    </div>
                                </div>
                            </div>

                            <div class="payment-method-card" id="acleda-payment-card">
                                <div class="payment-title">
                                    <input type="radio" id="acleda_payment" name="payment_method" value="acleda"
                                        required>
                                    <img src="/images/acleda-logo.png" alt="ACLEDA Bank" class="payment-icon">
                                    <label for="acleda_payment" class="form-check-label fw-bold">ACLEDA Bank</label>
                                </div>
                                <div class="payment-method-details">
                                    <p>Pay securely with ACLEDA Bank. You will be redirected to ACLEDA's payment gateway to
                                        complete your transaction.</p>
                                    <div class="mb-3">
                                        <label for="acleda_account_name" class="form-label">Account Name
                                            (Optional)</label>
                                        <input type="text" class="form-control" id="acleda_account_name"
                                            name="acleda_account_name" placeholder="Enter account name">
                                    </div>
                                </div>
                            </div>

                            <div class="payment-method-card" id="other-payment-card">
                                <div class="payment-title">
                                    <input type="radio" id="other_payment" name="payment_method" value="other"
                                        required>
                                    <img src="/images/other-payment.png" alt="Other Payment" class="payment-icon">
                                    <label for="other_payment" class="form-check-label fw-bold">Other Payment
                                        Method</label>
                                </div>
                                <div class="payment-method-details">
                                    <p>Choose from other available payment options.</p>
                                    <div class="mb-3">
                                        <label for="other_payment_type" class="form-label">Select Payment Type</label>
                                        <select class="form-select" id="other_payment_type" name="other_payment_type">
                                            <option value="wing">Wing</option>
                                            <option value="pipay">PiPay</option>
                                            <option value="cash_on_delivery">Cash on Delivery</option>
                                            <option value="credit_card">Credit Card</option>
                                            <option value="paypal">PayPal</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="other_payment_details" class="form-label">Payment Details
                                            (Optional)</label>
                                        <textarea class="form-control" id="other_payment_details" name="other_payment_details" rows="3"
                                            placeholder="Any additional payment information"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="invalid-feedback" id="payment-method-error">Please select a payment method.</div>
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
                <div class="card sticky-top" style="top: 20px;">
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
                            <span>Shipping:</span>
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

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
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

            // Payment method selection
            setupPaymentMethodSelection();
        });

        function setupPaymentMethodSelection() {
            const paymentCards = document.querySelectorAll('.payment-method-card');

            paymentCards.forEach(card => {
                const radio = card.querySelector('input[type="radio"]');

                // When card is clicked, select the radio button
                card.addEventListener('click', function(e) {
                    if (e.target.type !== 'radio' && e.target.tagName !== 'INPUT' && e.target.tagName !==
                        'LABEL') {
                        radio.checked = true;
                    }

                    // Update UI for all cards
                    paymentCards.forEach(c => {
                        c.classList.remove('selected');
                        const paymentError = document.getElementById('payment-method-error');
                        if (paymentError) paymentError.style.display = 'none';
                    });

                    // Add selected class to current card
                    card.classList.add('selected');
                });

                // When radio is clicked directly, update UI
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        paymentCards.forEach(c => c.classList.remove('selected'));
                        card.classList.add('selected');
                        const paymentError = document.getElementById('payment-method-error');
                        if (paymentError) paymentError.style.display = 'none';
                    }
                });
            });
        }

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
                // Disable place order button if cart is empty
                document.getElementById('placeOrderBtn').disabled = true;
                return;
            }

            let subtotal = 0;
            let totalDiscount = 0;
            let html = '';

            cart.forEach((item, index) => {
                const itemPrice = item.discount ?
                    item.price * (1 - item.discount / 100) :
                    item.price;

                const itemTotal = itemPrice * item.quantity;
                const itemOriginalTotal = item.price * item.quantity;
                const itemDiscount = itemOriginalTotal - itemTotal;

                subtotal += itemOriginalTotal;
                totalDiscount += itemDiscount;

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
                            ${item.discount ? 
                                `<small class="text-muted text-decoration-line-through">$${itemOriginalTotal.toFixed(2)}</small>` : 
                                ''
                            }
                        </div>
                    </div>
                `;
            });

            // Calculate totals (without tax)
            const shipping = 10.00; // Fixed shipping cost
            const total = (subtotal - totalDiscount) + shipping;

            // Update the UI
            orderItemsContainer.innerHTML = html;
            subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
            discountElement.textContent = `-$${totalDiscount.toFixed(2)}`;
            shippingElement.textContent = `$${shipping.toFixed(2)}`;
            totalElement.textContent = `$${total.toFixed(2)}`;

            // Store the calculated totals for the order submission
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
            const requiredFields = ['customer_first_name', 'customer_last_name', 'customer_email', 'shipping_address',
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

            // Payment method validation
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            if (!paymentMethod) {
                const paymentError = document.getElementById('payment-method-error');
                if (paymentError) paymentError.style.display = 'block';
                isValid = false;
            }

            if (!isValid) {
                showToast('Please fill in all required fields.', 'danger');
                return;
            }

            if (cart.length === 0) {
                showToast('Your cart is empty. Please add items to your cart before placing an order.', 'warning');
                return;
            }

            // Collect payment method details
            const paymentDetails = {
                method: paymentMethod.value
            };

            if (paymentMethod.value === 'aba') {
                paymentDetails.account_name = document.getElementById('aba_account_name').value;
            } else if (paymentMethod.value === 'acleda') {
                paymentDetails.account_name = document.getElementById('acleda_account_name').value;
            } else if (paymentMethod.value === 'other') {
                paymentDetails.type = document.getElementById('other_payment_type').value;
                paymentDetails.details = document.getElementById('other_payment_details').value;
            }

            const orderData = {
                customer_first_name: document.getElementById('customer_first_name').value,
                customer_last_name: document.getElementById('customer_last_name').value,
                customer_email: document.getElementById('customer_email').value,
                customer_phone: document.getElementById('customer_phone').value,
                shipping_address: document.getElementById('shipping_address').value,
                billing_address: document.getElementById('billing_address').value,
                customer_notes: document.getElementById('customer_notes').value,
                payment_method: paymentDetails,
                cart_items: cart,
                subtotal: window.cartTotals?.subtotal || 0,
                discount_amount: window.cartTotals?.discount_amount || 0,
                shipping_amount: window.cartTotals?.shipping_amount || 0,
                total_amount: window.cartTotals?.total_amount || 0
            };

            submitOrder(orderData);
        }

        function submitOrder(orderData) {
            const submitBtn = document.getElementById('placeOrderBtn');
            const originalText = submitBtn.innerHTML;

            // Show loading state
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Processing...';
            submitBtn.disabled = true;

            // Create FormData instead of JSON for better compatibility
            const formData = new FormData();

            // Add all form fields
            formData.append('customer_first_name', orderData.customer_first_name);
            formData.append('customer_last_name', orderData.customer_last_name);
            formData.append('customer_email', orderData.customer_email);
            formData.append('customer_phone', orderData.customer_phone || '');
            formData.append('shipping_address', orderData.shipping_address);
            formData.append('billing_address', orderData.billing_address);
            formData.append('customer_notes', orderData.customer_notes || '');
            formData.append('payment_method', JSON.stringify(orderData.payment_method));

            // Add cart and totals
            formData.append('cart_items', JSON.stringify(orderData.cart_items));
            formData.append('subtotal', orderData.subtotal);
            formData.append('discount_amount', orderData.discount_amount);
            formData.append('shipping_amount', orderData.shipping_amount);
            formData.append('total_amount', orderData.total_amount);
            formData.append('_token', '{{ csrf_token() }}');

            console.log('Sending order data:', orderData); // Debug log

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
                    console.log('Response status:', response.status); // Debug log
                    if (!response.ok) {
                        return response.json().then(err => {
                            console.log('Error response:', err); // Debug log
                            throw err;
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Success response:', data); // Debug log
                    if (data.success) {
                        showToast(data.message, 'success');

                        // Clear the cart from localStorage
                        localStorage.removeItem("shoppingCart");

                        // Redirect to confirmation page
                        setTimeout(() => {
                            window.location.href = data.redirect_url;
                        }, 1500);
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
                    }

                    showToast(errorMessage, 'danger');

                    // Reset button
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
        }
    </script>
@endsection
