<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .checkout-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
            overflow: hidden;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 20px;
        }

        .card-header h4 {
            margin: 0;
            font-weight: 600;
            color: #333;
            font-size: 1.3rem;
        }

        .card-body {
            padding: 24px;
        }

        .checkout-title {
            color: #333;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #555;
        }

        .form-control {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: #fbfbfb;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .btn-primary {
            background-color: #0d6efd;
            border: none;
            padding: 12px 16px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
        }

        .cart-item {
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .item-image {
            border-radius: 8px;
            object-fit: cover;
            width: 80px;
            height: 80px;
        }

        .item-details h6 {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .text-muted {
            color: #6c757d;
        }

        .total-section {
            font-size: 1.05rem;
        }

        .total-section .fw-bold {
            font-size: 1.25rem;
            color: #333;
        }

        .card-icon {
            margin-right: 8px;
            color: #0d6efd;
        }

        .secure-badge {
            display: flex;
            align-items: center;
            color: #28a745;
            font-size: 0.9rem;
            margin-top: 16px;
        }

        .progress-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .step {
            flex: 1;
            text-align: center;
            position: relative;
        }

        .step-circle {
            width: 30px;
            height: 30px;
            background-color: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            font-weight: 600;
            color: #6c757d;
        }

        .step.active .step-circle {
            background-color: #0d6efd;
            color: white;
        }

        .step-title {
            font-size: 0.85rem;
            font-weight: 500;
            color: #6c757d;
        }

        .step.active .step-title {
            color: #0d6efd;
            font-weight: 600;
        }

        .step-line {
            position: absolute;
            top: 15px;
            height: 2px;
            background-color: #e9ecef;
            width: 100%;
            left: 50%;
            z-index: -1;
        }

        .step:first-child .step-line {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container py-5 checkout-container">
   

        <h1 class="checkout-title">Complete Your Purchase</h1>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4><i class="fas fa-shopping-bag card-icon"></i>Order Summary</h4>
                    </div>
                    <div class="card-body" id="cartItems">
                        <!-- Cart items will be loaded here -->
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-credit-card card-icon"></i>Payment Information</h4>
                    </div>
                    <div class="card-body">
                        <form id="paymentForm">
                            <div class="mb-3">
                                <label for="cardName" class="form-label">Name on Card</label>
                                <input type="text" class="form-control" id="cardName" placeholder="John Smith"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="cardNumber" class="form-label">Card Number</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="cardNumber"
                                        placeholder="1234 5678 9012 3456" required>
                                    <span class="input-group-text bg-white">
                                        <i class="fab fa-cc-visa text-primary mx-1"></i>
                                        <i class="fab fa-cc-mastercard text-danger mx-1"></i>
                                        <i class="fab fa-cc-amex text-info mx-1"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="expiryMonth" class="form-label">Expiry Month</label>
                                    <input type="text" class="form-control" id="expiryMonth" placeholder="MM"
                                        required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="expiryYear" class="form-label">Expiry Year</label>
                                    <input type="text" class="form-control" id="expiryYear" placeholder="YY"
                                        required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="cvv" placeholder="123"
                                            required>
                                        <span class="input-group-text bg-white text-muted"
                                            title="3-digit security code on the back of your card">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-lock me-2"></i>Complete Purchase
                            </button>
                            <div class="secure-badge text-center mt-3">
                                <i class="fas fa-shield-alt me-2"></i> Your payment information is secured with SSL
                                encryption
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header">
                        <h4><i class="fas fa-receipt card-icon"></i>Order Total</h4>
                    </div>
                    <div class="card-body">
                        <div class="total-section">
                            <div class="d-flex justify-content-between mb-3">
                                <span>Subtotal:</span>
                                <span id="subtotal">$0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Shipping:</span>
                                <span>$5.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Tax:</span>
                                <span id="tax">$0.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total:</span>
                                <span id="total">$0.00</span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-truck text-success me-3 fa-lg"></i>
                                <div>
                                    <div class="fw-bold">Free shipping on orders over $50</div>
                                    <small class="text-muted">Estimated delivery: 3-5 business days</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-undo text-success me-3 fa-lg"></i>
                                <div>
                                    <div class="fw-bold">30-day returns</div>
                                    <small class="text-muted">Free returns on all orders</small>
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
            // Load cart items from localStorage
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const cartItemsContainer = document.getElementById('cartItems');

            if (cart.length === 0) {
                cartItemsContainer.innerHTML =
                    '<div class="text-center py-4"><i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i><p>Your cart is empty</p><a href="/" class="btn btn-outline-primary">Continue Shopping</a></div>';
                return;
            }

            let itemsHTML = '';
            let subtotal = 0;

            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;

                itemsHTML += `
                    <div class="cart-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="/storage/${item.picture_url}" class="item-image me-4" alt="${item.name}">
                                <div class="item-details">
                                    <h6>${item.name}</h6>
                                    <div class="text-muted mb-1">Size: ${item.size}</div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-light text-dark me-2">Qty: ${item.quantity}</span>
                                        <span class="fw-semibold">$${item.price.toFixed(2)}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold">$${(item.price * item.quantity).toFixed(2)}</div>
                            </div>
                        </div>
                    </div>
                `;
            });

            cartItemsContainer.innerHTML = itemsHTML;

            // Calculate totals
            const tax = subtotal * 0.1; // 10% tax
            const shipping = 5.00;
            const total = subtotal + tax + shipping;

            document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('tax').textContent = `$${tax.toFixed(2)}`;
            document.getElementById('total').textContent = `$${total.toFixed(2)}`;

            // Handle form submission
            document.getElementById('paymentForm').addEventListener('submit', function(e) {
                e.preventDefault();

                // Simple loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Processing...';

                // Simulate processing delay for better UX
                setTimeout(function() {
                    // In a real app, you would process payment here
                    alert('Payment processed successfully!');
                    localStorage.removeItem('cart');
                    window.location.href = "/";
                }, 1500);
            });

            // Format credit card input
            const cardNumberInput = document.getElementById('cardNumber');
            cardNumberInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                let formattedValue = '';

                for (let i = 0; i < value.length; i++) {
                    if (i > 0 && i % 4 === 0) {
                        formattedValue += ' ';
                    }
                    formattedValue += value[i];
                }

                e.target.value = formattedValue;
            });
        });
    </script>
</body>

</html>
