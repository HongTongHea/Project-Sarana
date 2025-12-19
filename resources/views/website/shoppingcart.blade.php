<!-- Add to Cart Modal -->
<div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light border-bottom">
                <h5 class="modal-title fw-bold" id="addToCartModalLabel">
                    Product Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4 text-center">
                        <img id="modalProductImg" src="" alt="Product Image" class="img-fluid rounded shadow-sm"
                            style="max-height: 180px;">
                    </div>

                    <div class="col-md-8">
                        <h5 id="modalProductName" class="fw-semibold mb-2"></h5>
                        <p class="mb-1" id="modalProductPriceContainer">
                            Price: <strong id="modalProductPrice" class="text-dark"></strong>
                            <span id="modalProductOriginalPrice"
                                class="text-muted text-decoration-line-through small ms-2"></span>
                            <span id="modalProductDiscount" class="badge bg-danger ms-2"></span>
                        </p>

                        <p class="mb-1 small stock-status"></p>

                        <div class="mb-3">
                            <h6 class="fw-semibold">Detail</h6>
                            <p id="modalProductDescription" class="text-muted small"></p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block fw-semibold">Quantity</label>
                            <div class="input-group input-group-sm w-50">
                                <button class="btn btn-outline-secondary" type="button" id="decreaseQty"><i
                                        class="bi bi-dash"></i></button>
                                <input type="number" id="productQty" class="form-control text-center" min="1"
                                    value="1" />
                                <button class="btn btn-outline-secondary" type="button" id="increaseQty"><i
                                        class="bi bi-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i
                        class="fas fa-times me-1"></i>Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmAddToCart">
                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Shopping Cart Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas"
    data-is-logged-in="{{ auth()->check() ? 'true' : 'false' }}">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title"><i class="fas fa-shopping-cart me-1"></i> Your Shopping Cart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <div class="cart-items">
            <div class="text-center py-4">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <p>Your cart is empty</p>
            </div>
            <!-- Cart items will be dynamically added here -->
        </div>
        <div class="cart-summary"> <!-- Remove d-none class -->
            <hr>
            <div class="d-flex justify-content-between mb-2">
                <span>Subtotal:</span>
                <span class="cart-subtotal">$0.00</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Discount:</span>
                <span class="cart-discount">-$0.00</span>
            </div>
            <div class="d-flex justify-content-between fw-bold">
                <span>Total:</span>
                <span class="cart-total">$0.00</span>
            </div>

            <!-- Checkout Button -->
            <button class="btn btn-primary w-100 mt-3" id="proceedToCheckout">
                Proceed to Checkout
            </button>
        </div>
        <!-- Login Required Alert - Shown when user is not logged in -->
        <div class="alert alert-warning mt-3 {{ auth()->check() ? 'd-none' : '' }}" id="loginRequiredAlert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            Please <a href="/login" class="alert-link">login</a> or
            <a href="/register" class="alert-link">register</a> to proceed with your purchase.
        </div>

    </div>
</div>
<!-- JS Fix -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cartOffcanvas = document.getElementById('cartOffcanvas');
        const isLoggedIn = cartOffcanvas.dataset.isLoggedIn === 'true';
        const checkoutBtn = document.getElementById('proceedToCheckout');
        const loginAlert = document.getElementById('loginRequiredAlert');

        // Show/hide login alert based on login status
        if (!isLoggedIn) {
            // Show login alert when user is not logged in
            loginAlert.classList.remove('d-none');
        } else {
            // Hide login alert when user is logged in
            loginAlert.classList.add('d-none');
        }

        // Handle checkout button click
        checkoutBtn.addEventListener('click', function(e) {
            if (!isLoggedIn) {
                // Prevent checkout and scroll to login alert
                e.preventDefault();
                loginAlert.classList.remove('d-none');
                loginAlert.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                // Optional: Add highlight effect to the alert
                loginAlert.classList.add('alert-highlight');
                setTimeout(() => {
                    loginAlert.classList.remove('alert-highlight');
                }, 1500);
            } else {
                // User is logged in, redirect to checkout
                window.location.href = '/checkout';
            }
        });

        // Optional: Add CSS for highlight effect
        const style = document.createElement('style');
        style.textContent = `
            .alert-highlight {
                animation: pulse 1.5s ease-in-out;
                border: 2px solid #ffc107;
            }
            @keyframes pulse {
                0% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7); }
                70% { box-shadow: 0 0 0 10px rgba(255, 193, 7, 0); }
                100% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0); }
            }
        `;
        document.head.appendChild(style);
    });

    // Function to update login status dynamically (if user logs in/out without page reload)
    function updateCartLoginStatus(isLoggedIn) {
        const cartOffcanvas = document.getElementById('cartOffcanvas');
        const loginAlert = document.getElementById('loginRequiredAlert');
        const checkoutBtn = document.getElementById('proceedToCheckout');

        // Update data attribute
        cartOffcanvas.dataset.isLoggedIn = isLoggedIn;

        // Show/hide alert based on new login status
        if (!isLoggedIn) {
            loginAlert.classList.remove('d-none');
            checkoutBtn.disabled = false; // Keep button enabled but will show alert on click
        } else {
            loginAlert.classList.add('d-none');
            checkoutBtn.disabled = false;
        }
    }

    // Optional: Function to show cart and focus on login alert for non-logged users
    function showCartWithLoginAlert() {
        const cartOffcanvas = new bootstrap.Offcanvas(document.getElementById('cartOffcanvas'));
        const isLoggedIn = document.getElementById('cartOffcanvas').dataset.isLoggedIn === 'true';
        const loginAlert = document.getElementById('loginRequiredAlert');

        cartOffcanvas.show();

        // If not logged in, focus on the login alert after a short delay
        if (!isLoggedIn) {
            setTimeout(() => {
                loginAlert.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }, 300);
        }
    }
</script>
