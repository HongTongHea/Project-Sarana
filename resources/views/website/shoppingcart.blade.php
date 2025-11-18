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
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
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
        <h5 class="offcanvas-title">Your Shopping Cart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <div class="cart-items">
            <div class="text-center py-4 empty-cart-message">
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

            <!-- Login Required Alert -->
            <div class="alert alert-warning mt-3 d-none" id="loginRequiredAlert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Please <a href="/login" class="alert-link">login</a> to proceed with your purchase.
            </div>
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

        // Redirect on checkout
        checkoutBtn.addEventListener('click', function() {
            if (!isLoggedIn) {
                // Show login required
                loginAlert.classList.remove('d-none');
                loginAlert.scrollIntoView({
                    behavior: 'smooth'
                });
            } else {
                // ✅ Redirect to Laravel checkout route
                window.location.href = '/checkout';
            }
        });

        // Hide alert when clicking login link
        loginAlert.querySelector('a').addEventListener('click', function() {
            loginAlert.classList.add('d-none');
        });
    });

    // Sync login status dynamically if needed
    function updateCartLoginStatus(isLoggedIn) {
        const cartOffcanvas = document.getElementById('cartOffcanvas');
        cartOffcanvas.dataset.isLoggedIn = isLoggedIn;
    }
</script>
