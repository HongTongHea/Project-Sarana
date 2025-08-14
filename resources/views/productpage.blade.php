@extends('website.app')
@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col text-start">
                <h3 class="fw-bold">Browse by Categories</h3>
                <p class="text-muted">Browse our wide range of categories</p>
            </div>
        </div>
        <div class="row" id="categories-section">
            @foreach ($categories as $index => $category)
                @if ($index >= 5)
                    @break
                @endif
                <div class="col-6 col-sm-4 col-md-3 col-lg-2-4 mb-3">
                    <div class="card category-card h-100 border-0 shadow-sm hover-effect rounded-3 category-item"
                        data-category-id="{{ $category->id }}" style="cursor: pointer;">
                        <div class="card-body text-center d-flex flex-column justify-content-center p-2">
                            <h5 class="card-title fw-semibold mb-0 fs-6 text-uppercase">
                                {{ $category->name }}
                            </h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Products Section -->
        <section class="mb-5" id="products-section">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="row mb-2">
                    <div class="col text-start">
                        <h3 class="mb-0 text-start font-weight-bold" id="products-title">Featured Products</h3>
                        <p class="text-muted">Browse our selection of featured products</p>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <button class="btn btn-outline-primary btn-sm" id="see-all-btn" style="display: none;">See All</button>
                </div>
            </div>

            <div class="row" id="products-container">
                @foreach ($products as $product)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2-4 mb-4 product-item"
                        data-category-id="{{ $product->category_id }}">
                        <div class="card border-0 position-relative product-card">
                            @if ($product->discount_percentage > 0)
                                <span
                                    class="badge bg-danger position-absolute top-0 start-0 m-2 z-3">-{{ $product->discount_percentage }}%</span>
                            @endif
                            <div class="overflow-hidden product-image-container position-relative">
                                <img src="{{ asset('storage/' . $product->picture_url) }}" alt="{{ $product->name }}"
                                    class="card-img-top img-fluid product-image mt-2">

                                <button
                                    class="btn btn-sm position-absolute top-5 end-0 m-2 border-0 bg-white rounded-circle shadow-sm"
                                    style="margin-top: 8rem !important;">
                                    <i class="far fa-heart text-dark"></i>
                                </button>
                            </div>

                            <div class="card-body p-2">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    @if ($product->discount_percentage > 0)
                                        <span class="text-danger fw-bold me-1">
                                            ${{ number_format($product->price - ($product->price * $product->discount_percentage) / 100, 2) }}
                                        </span>
                                        <span class="text-muted text-decoration-line-through small">
                                            ${{ number_format($product->price, 2) }}
                                        </span>
                                    @else
                                        <span class="text-dark fw-bold">
                                            ${{ number_format($product->price, 2) }}
                                        </span>
                                    @endif

                                </div>
                                <p class="mb-1  small {{ $product->stock_quantity > 0 ? 'text-warning' : 'text-danger' }}">
                                    {!! $product->stock_quantity > 0
                                        ? '<i class="fas fa-check-circle me-1"></i>In stock'
                                        : '<i class="fas fa-times-circle me-1"></i>Out stock' !!}
                                </p>

                                <div class="d-flex flex-column">
                                    <p class="mb-1 fw-semibold">{{ $product->name }}</p>

                                    <p class="mb-0 text-muted small d-none">{{ $product->description }}</p>
                                </div>

                                <button class="btn btn-outline-primary btn-sm mt-2 w-100 add-to-cart-btn"
                                    data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                    data-price="{{ $product->price }}" data-discount="{{ $product->discount_percentage }}"
                                    data-img="{{ asset('storage/' . $product->picture_url) }}"
                                    data-stock="{{ $product->stock_quantity }}" data-barcode="{{ $product->barcode }}">
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
                                <p class="mb-1" id="modalProductPriceContainer">
                                    Price: <strong id="modalProductPrice" class="text-dark"></strong>
                                    <span id="modalProductOriginalPrice"
                                        class="text-muted text-decoration-line-through small ms-2"></span>
                                    <span id="modalProductDiscount" class="badge bg-danger ms-2"></span>
                                </p>

                                <p class="mb-1 small stock-status"></p>

                                <!-- Product Description -->
                                <div class="mb-3">
                                    <h6 class="fw-semibold">Detail</h6>
                                    <p id="modalProductDescription" class="text-muted small"></p>
                                </div>


                                <!-- Quantity Selection -->
                                <div class="mb-3">
                                    <label class="form-label d-block fw-semibold">Quantity</label>
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
                    <div class="d-flex justify-content-between mb-2">
                        <span>Discount:</span>
                        <span class="cart-discount">-$0.00</span>
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
