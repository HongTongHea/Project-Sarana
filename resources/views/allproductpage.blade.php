@extends('website.app')
@section('content')
    <div class="container">
        <!-- Brand Scrolling Section -->
        <div class="brand-section mt-2 mb-2">
            <div class="container">
                <h2 class="mb-0 text-center fw-bold text-black mt-5">Our Branding</h2> 
                <p class="text-muted text-center">Discover a wide range of top-notch products from our trusted brands</p>
                <div class="brand-scroller">
                    <div class="brand-track">
                        <img src="{{ asset('assets/logo/dell-logo.png') }}" alt="Dell", style="height: 30px; width: auto;">
                        <img src="{{ asset('assets/logo/asus-logo.png') }}" alt="Asus">
                        <img src="{{ asset('assets/logo/apple-logo.png') }}" alt="Apple">
                        <img src="{{ asset('assets/logo/samsung-logo.png') }}" alt="Samsung">
                        <img src="{{ asset('assets/logo/lenovo-logo.png') }}" alt="Lenovo"
                            style="height: 30px; width: auto;">
                        <img src="{{ asset('assets/logo/acer-logo.png') }}" alt="Acer">

                        <!-- Duplicate for seamless loop -->
                        <img src="{{ asset('assets/logo/dell-logo.png') }}" alt="Dell"
                            style="height: 30px; width: auto;">
                        <img src="{{ asset('assets/logo/asus-logo.png') }}" alt="Asus">
                        <img src="{{ asset('assets/logo/apple-logo.png') }}" alt="Apple">
                        <img src="{{ asset('assets/logo/samsung-logo.png') }}" alt="Samsung">
                        <img src="{{ asset('assets/logo/lenovo-logo.png') }}" alt="Lenovo"
                            style="height: 30px; width: auto;">
                        <img src="{{ asset('assets/logo/acer-logo.png') }}" alt="Acer">
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="row mb-2">
                <div class="col text-start">
                    <h3 id="products-title" class="mb-0 text-start fw-bold text-black">All Products & Accessories
                    </h3>
                    <p class="text-muted">Browse our selection of all products and accessories</p>
                </div>
            </div>
        </div>

        <section id="products-section">
            <div class="row" id="products-container">
                @foreach ($products as $index => $product)
                    <div class="col-6 col-sm-4 col-md-4 col-lg-2-4 mb-4 product-item"
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
                                <p class="mb-1 small {{ $product->stock_quantity > 0 ? 'text-warning' : 'text-danger' }}">
                                    {!! $product->stock_quantity > 0
                                        ? '<i class="fas fa-check-circle me-1"></i>In stock'
                                        : '<i class="fas fa-times-circle me-1"></i>Out stock' !!}
                                </p>

                                <div class="d-flex flex-column">
                                    <p class="mb-1 fw-semibold">{{ $product->name }}</p>
                                </div>

                                <button class="btn btn-outline-primary btn-sm mt-2 w-100 add-to-cart-btn"
                                    data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                    data-price="{{ $product->price }}" data-discount="{{ $product->discount_percentage }}"
                                    data-img="{{ asset('storage/' . $product->picture_url) }}"
                                    data-stock="{{ $product->stock_quantity }}" data-barcode="{{ $product->barcode }}"
                                    data-description="{{ $product->description }}">
                                    <i class="fas fa-shopping-cart me-1"></i>
                                    Add to Cart
                                </button>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Accessories Section -->
        <section>
            <div class="row" id="accessories-container">
                @foreach ($accessories as $index => $accessory)
                    <div class="col-6 col-sm-4 col-md-4 col-lg-2-4 mb-4 accessory-item">
                        <div class="card border-0 position-relative product-card">
                            @if ($accessory->discount_percentage > 0)
                                <span
                                    class="badge bg-danger position-absolute top-0 start-0 m-2 z-3">-{{ $accessory->discount_percentage }}%</span>
                            @endif
                            <div class="overflow-hidden product-image-container position-relative">
                                <img src="{{ asset('storage/' . $accessory->picture_url) }}" alt="{{ $accessory->name }}"
                                    class="card-img-top img-fluid product-image mt-2">

                                <button
                                    class="btn btn-sm position-absolute top-5 end-0 m-2 border-0 bg-white rounded-circle shadow-sm"
                                    style="margin-top: 8rem !important;">
                                    <i class="far fa-heart text-dark"></i>
                                </button>
                            </div>

                            <div class="card-body p-2">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    @if ($accessory->discount_percentage > 0)
                                        <span class="text-danger fw-bold me-1">
                                            ${{ number_format($accessory->price - ($accessory->price * $accessory->discount_percentage) / 100, 2) }}
                                        </span>
                                        <span class="text-muted text-decoration-line-through small">
                                            ${{ number_format($accessory->price, 2) }}
                                        </span>
                                    @else
                                        <span class="text-dark fw-bold">
                                            ${{ number_format($accessory->price, 2) }}
                                        </span>
                                    @endif
                                </div>
                                <p
                                    class="mb-1 small {{ $accessory->stock_quantity > 0 ? 'text-warning' : 'text-danger' }}">
                                    {!! $accessory->stock_quantity > 0
                                        ? '<i class="fas fa-check-circle me-1"></i>In stock'
                                        : '<i class="fas fa-times-circle me-1"></i>Out stock' !!}
                                </p>

                                <div class="d-flex flex-column">
                                    <p class="mb-1 fw-semibold">{{ $accessory->name }}</p>
                                </div>

                                <button class="btn btn-outline-primary btn-sm mt-2 w-100 add-to-cart-btn"
                                    data-id="{{ $accessory->id }}" data-name="{{ $accessory->name }}"
                                    data-price="{{ $accessory->price }}"
                                    data-discount="{{ $accessory->discount_percentage }}"
                                    data-img="{{ asset('storage/' . $accessory->picture_url) }}"
                                    data-stock="{{ $accessory->stock_quantity }}" data-barcode="{{ $accessory->barcode }}"
                                    data-description="{{ $accessory->description }}">
                                    <i class="fas fa-shopping-cart me-1"></i>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        @include('website.shoppingcart')
    </div>

    <!-- ✅ Toast container (center top) -->
    <div id="cartToastContainer" class="toast-container position-fixed top-0 end-0 p-3"></div>
@endsection
