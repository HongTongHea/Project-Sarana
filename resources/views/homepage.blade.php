<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fashion Boutique - E-commerce</title>
    <link rel="stylesheet" href="./assets/css/website.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        .badge-discount {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: red;
            color: white;
            padding: 5px 10px;
            font-size: 0.8rem;
            border-radius: 0.25rem;
        }

        .cart-icon {
            position: relative;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 0 6px;
            font-size: 12px;
        }

        .product-card {
            margin-bottom: 30px;
        }

        .product-img {
            height: 250px;
            object-fit: cover;
        }

        .cart-item-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .cart-item-details {
            flex-grow: 1;
            margin-left: 10px;
        }

        /* Custom 5-column grid */
        @media (min-width: 1200px) {
            .col-lg-2-4 {
                flex: 0 0 20%;
                max-width: 20%;
            }
        }

        .card-img-top {
            border-radius: 0;
            transition: transform 0.3s ease;
        }

        .card:hover .card-img-top {
            transform: scale(1.02);
        }

        .product-image-container {
            height: 160px;
            /* Slightly smaller for 5 columns */
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .card-title {
            font-size: 0.95rem;
            color: #333;
        }

        .btn-outline-primary {
            border-width: 1.5px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .sizes-container {
            min-height: 36px;
        }

        /* Responsive adjustments */
        @media (max-width: 767px) {
            .product-image-container {
                height: 120px;
            }

            .card-body {
                padding: 1rem 0.75rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">Fashion Boutique</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Men</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Women</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Kids</a></li>
                </ul>
                <div class="d-flex">
                    <button class="btn btn-outline-dark me-2" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#cartOffcanvas">
                        <i class="fas fa-shopping-cart cart-icon">
                            <span class="cart-count">0</span>
                        </i>
                    </button>
                    <a href="{{ route('login') }}" class="btn btn-primary">Sign In</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero-section text-center py-5">
        <div class="container">
            <h1 class="display-4 fw-bold">Summer Collection 2025</h1>
            <p class="lead">Discover our new arrivals and trendy outfits</p>
            <a href="#products" class="btn btn-primary btn-lg">Shop Now</a>
        </div>
    </section>

    <section class="container mb-5" id="products">
        <h3 class="mb-4 text-center font-weight-bold">Featured Products</h3>
        <div class="row">
            @foreach ($products as $product)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2-4 mb-4">
                    <div class="card border-0 position-relative product-card">
                        <div class="position-relative overflow-hidden product-image-container">
                            <img src="{{ asset('storage/' . $product->picture_url) }}" alt="{{ $product->name }}"
                                class="card-img-top img-fluid product-image">

                            <button
                                class="btn btn-sm position-absolute bottom-0 end-0 m-2 border-0 bg-white rounded-circle shadow-sm">
                                <i class="far fa-heart text-dark"></i>
                            </button>
                        </div>

                        <div class="card-body p-2">
                            <p class="mb-1 text-dark fw-bold">
                                <i class="fas fa-dollar-sign me-1 text-success"></i>
                                {{ number_format($product->price, 2) }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-0 text-muted small">{{ $product->name }}</p>
                                <p
                                    class="mb-0 small {{ $product->stock_quantity > 0 ? 'text-warning' : 'text-danger' }}">
                                    {!! $product->stock_quantity > 0
                                        ? '<i class="fas fa-check-circle me-1"></i>In stock'
                                        : '<i class="fas fa-times-circle me-1"></i>Out of stock' !!}
                                </p>
                            </div>

                            <button class="btn btn-outline-primary btn-sm mt-2 w-100 add-to-cart-btn"
                                data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                data-price="{{ $product->price }}"
                                data-img="{{ asset('storage/' . $product->picture_url) }}"
                                data-stock="{{ $product->stock_quantity }}">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Add to Cart Modal -->
    <div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title fw-bold" id="addToCartModalLabel">
                        <i class="bi bi-bag-plus me-2"></i>Product Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3 align-items-center">
                        <!-- Product Image -->
                        <div class="col-md-4 text-center">
                            <img id="modalProductImg" src="" alt="Product Image"
                                class="img-fluid rounded shadow-sm" style="max-height: 180px;">
                        </div>

                        <!-- Product Info and Controls -->
                        <div class="col-md-8">
                            <h5 id="modalProductName" class="fw-semibold mb-2"></h5>
                            <p class="text-muted mb-1">Price: <strong id="modalProductPrice"
                                    class="text-dark"></strong></p>
                            <p class="mb-1 small stock-status">
                                <!-- Stock status will be filled by JavaScript -->
                            </p>

                            <!-- Size Selection -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="productSize" class="form-label">Select Size</label>
                                    <select id="productSize" class="form-select form-select-sm">
                                        <option value="S">Small</option>
                                        <option value="M" selected>Medium</option>
                                        <option value="L">Large</option>
                                        <option value="XL">X-Large</option>
                                    </select>
                                </div>

                                <!-- Quantity Selection -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label d-block">Quantity</label>
                                    <div class="input-group input-group-sm w-50">
                                        <button class="btn btn-outline-secondary" type="button" id="decreaseQty">
                                            <i class="bi bi-dash">-</i>
                                        </button>
                                        <input type="number" id="productQty" class="form-control text-center"
                                            min="1" value="1" />
                                        <button class="btn btn-outline-secondary" type="button" id="increaseQty">
                                            <i class="bi bi-plus">+</i>
                                        </button>
                                    </div>
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
    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas">
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
            </div>
            <div class="cart-summary d-none">
                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span class="cart-subtotal">$0.00</span>
                </div>
                <div class="d-flex justify-content-between fw-bold">
                    <span>Total:</span>
                    <span class="cart-total">$0.00</span>
                </div>
                <button class="btn btn-primary w-100 mt-3">Proceed to Checkout</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const cart = [];

        // DOM elements
        const addToCartModal = new bootstrap.Modal(document.getElementById('addToCartModal'));
        const modalProductImg = document.getElementById('modalProductImg');
        const modalProductName = document.getElementById('modalProductName');
        const modalProductPrice = document.getElementById('modalProductPrice');
        const productSize = document.getElementById('productSize');
        const productQty = document.getElementById('productQty');
        const cartItemsContainer = document.querySelector('.cart-items');
        const cartCount = document.querySelector('.cart-count');
        const cartSubtotal = document.querySelector('.cart-subtotal');
        const cartTotal = document.querySelector('.cart-total');
        const cartSummary = document.querySelector('.cart-summary');
        const emptyCartMessage = document.querySelector('.empty-cart-message');
        const stockStatusElement = document.querySelector('.stock-status');

        let currentProduct = {};

        // Open modal with product details
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', () => {
                currentProduct = {
                    id: button.dataset.id,
                    name: button.dataset.name,
                    price: parseFloat(button.dataset.price),
                    img: button.dataset.img,
                    stock: parseInt(button.dataset.stock)
                };

                modalProductImg.src = currentProduct.img;
                modalProductName.textContent = currentProduct.name;
                modalProductPrice.textContent = `$${currentProduct.price.toFixed(2)}`;
                productQty.value = 1;
                productSize.value = 'M';

                // Update stock status
                if (currentProduct.stock > 0) {
                    stockStatusElement.className = 'mb-1 small text-warning';
                    stockStatusElement.innerHTML = '<i class="fas fa-check-circle me-1"></i>In stock';
                } else {
                    stockStatusElement.className = 'mb-1 small text-danger';
                    stockStatusElement.innerHTML = '<i class="fas fa-times-circle me-1"></i>Out of stock';
                }

                addToCartModal.show();
            });
        });

        // Increase/Decrease Quantity
        document.getElementById('increaseQty').addEventListener('click', () => {
            productQty.value = parseInt(productQty.value) + 1;
        });

        document.getElementById('decreaseQty').addEventListener('click', () => {
            if (parseInt(productQty.value) > 1) {
                productQty.value = parseInt(productQty.value) - 1;
            }
        });

        // Confirm Add to Cart
        document.getElementById('confirmAddToCart').addEventListener('click', () => {
            const size = productSize.value;
            const quantity = parseInt(productQty.value);

            // Check if product is in stock
            if (currentProduct.stock <= 0) {
                alert('This product is out of stock!');
                return;
            }

            // Check if quantity exceeds available stock
            if (quantity > currentProduct.stock) {
                alert(`Only ${currentProduct.stock} items available in stock!`);
                return;
            }

            const cartItem = {
                ...currentProduct,
                size,
                quantity
            };

            cart.push(cartItem);
            updateCartUI();
            addToCartModal.hide();
        });

        function updateCartUI() {
            // Clear previous items
            cartItemsContainer.innerHTML = '';

            if (cart.length === 0) {
                emptyCartMessage.classList.remove('d-none');
                cartSummary.classList.add('d-none');
                if (cartCount) cartCount.textContent = '0';
                return;
            }

            emptyCartMessage.classList.add('d-none');
            cartSummary.classList.remove('d-none');

            let subtotal = 0;

            cart.forEach(item => {
                subtotal += item.price * item.quantity;

                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item d-flex align-items-center mb-3';

                cartItem.innerHTML = `
                <img src="${item.img}" alt="${item.name}" class="cart-item-img rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
                <div class="cart-item-details flex-grow-1">
                    <p class="mb-1 fw-bold">${item.name}</p>
                    <p class="mb-0 small text-muted">Size: ${item.size} | Qty: ${item.quantity}</p>
                    <p class="mb-0 small">$${(item.price * item.quantity).toFixed(2)}</p>
                </div>
                <button class="btn btn-sm btn-outline-danger remove-item-btn" data-id="${item.id}"><i class="fas fa-trash"></i></button>
            `;

                cartItemsContainer.appendChild(cartItem);
            });

            cartSubtotal.textContent = `$${subtotal.toFixed(2)}`;
            cartTotal.textContent = `$${subtotal.toFixed(2)}`;
            if (cartCount) cartCount.textContent = cart.length.toString();

            // Handle remove buttons
            document.querySelectorAll('.remove-item-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const idToRemove = btn.dataset.id;
                    const index = cart.findIndex(item => item.id === idToRemove);
                    if (index > -1) {
                        cart.splice(index, 1);
                        updateCartUI();
                    }
                });
            });
        }
    </script>


</body>

</html>
