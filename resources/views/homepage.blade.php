@extends('website.app')
@section('title', 'ANGKOR TECH COMPUTER | Home Page')
@section('content')
    <section>
        <div class="hero-slideshow">
            <div class="slide slide-1 active"
                style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/img/AsuszepyrusG16.jpg');">
                <div class="slide-content">
                    <h1 class="display-4 fw-bold">Summer Collection 2025</h1>
                    <p class="lead">Discover our new arrivals and trendy outfits</p>
                    <a href="#products-section" class="btn btn-primary btn-lg">Shop Now</a>
                </div>
            </div>
            <div class="slide slide-2"
                style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/img/allasus.jpg');">
                <div class="slide-content">
                    <h1 class="display-4 fw-bold">Beach Essentials</h1>
                    <p class="lead">Everything you need for your summer getaway</p>
                    <a href="#beach-collection" class="btn btn-primary btn-lg">View Collection</a>
                </div>
            </div>

            <div class="slide slide-3"
                style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/img/tuf.png');">
                <div class="slide-content">
                    <h1 class="display-4 fw-bold">Summer Accessories</h1>
                    <p class="lead">Complete your look with our stylish accessories</p>
                    <a href="#accessories" class="btn btn-primary btn-lg">Explore Now</a>
                </div>
            </div>

            <div class="slide-nav">
                <button class="slide-nav-btn prev-btn"><i class="fa-solid fa-chevron-left"></i></button>
                <button class="slide-nav-btn next-btn"><i class="fa-solid fa-chevron-right"></i></button>
            </div>

            <div class="slide-indicators">
                <div class="indicator active" data-slide="0"></div>
                <div class="indicator" data-slide="1"></div>
                <div class="indicator" data-slide="2"></div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row mb-4">
            <div class="col text-start">
                <h3 class="fw-bold">Browse by Categories</h3>
                <p class="text-muted">Browse our wide range of categories</p>
            </div>
        </div>
        <div class="row" id="categories-section">
            @foreach ($categories as $category)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2-4 mb-4">
                    <div class="card category-card h-100 border-0 shadow-sm hover-effect rounded-3 category-item"
                        data-category-id="{{ $category->id }}" style="cursor: pointer;">
                        <div class="card-body text-center d-flex flex-column justify-content-center p-3">
                            <div class="mb-2">
                                @php
                                    $categoryImages = [
                                        'computer' => 'computer.png',
                                        'accessories' => 'electronic-devices.png',
                                        'laptop' => 'computer (1).png',
                                    ];

                                    $iconKeys = array_keys($categoryImages);
                                    $imageIndex = $category->id % count($iconKeys);
                                    $imageKey = $iconKeys[$imageIndex];
                                    $imagePath = asset('assets/img/category-images/' . $categoryImages[$imageKey]);
                                @endphp
                                <img src="{{ $imagePath }}" alt="{{ $category->name }}" class="img-fluid"
                                    style="height: 40px; width: auto;">
                            </div>
                            <h5 class="card-title fw-semibold mb-0 fs-6 text-truncate">{{ $category->name }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <section class="mb-5" id="products-section">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="row mb-2">
                    <div class="col text-start">
                        <h3 class="mb-0 text-start font-weight-bold" id="products-title">Featured Products</h3>
                        <p class="text-muted">Browse our selection of featured products</p>
                    </div>
                </div>
                <div class="text-start">

                </div>

                <button class="btn btn-outline-primary btn-sm" id="see-all-btn">See All</button>
            </div>
            <div class="row" id="products-container">
                @foreach ($products as $product)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2-4 mb-4 product-item"
                        data-category-id="{{ $product->category_id }}">
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
                                    <i class="fas fa-shopping-cart me-1"></i>
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

                                <!-- Quantity Selection -->
                                <div class="mb-3">
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

    </div>
@endsection
