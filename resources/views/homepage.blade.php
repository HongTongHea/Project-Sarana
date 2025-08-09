@extends('website.app')
@section('title', 'ANGKOR TECH COMPUTER | Home Page')
@section('content')
    {{-- Hero Section --}}
    <section>
        <div class="hero-slideshow">
            <div class="slide slide-1 active" style="background-image: url('assets/img/slide (7).png');">
            </div>
            <div class="slide slide-2" style="background-image: url('assets/img/slide (6).png');">
            </div>
            <div class="slide slide-3" style="background-image: url('assets/img/slide (9).png');">
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
                <div class="text-start"></div>
                <div class="d-flex align-items-center mb-2">
                    <div class="input-group ">
                        <input type="text" id="productSearch" class="form-control" placeholder="Search products...">
                        <button class="btn btn-outline-secondary" type="button" id="searchButton">
                            <i class="fas fa-search"></i>
                        </button>
                        <button class="btn btn-outline-primary btn-sm ms-2" id="see-all-btn">See All</button>
                    </div>
                </div>

            </div>
            <div class="row" id="products-container">
                @foreach ($products as $index => $product)
                    @if ($index >= 10)
                        @break
                    @endif
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
        <section>
            <div class="row mb-2">
                <div class="col text-start">
                    <h3 class="mb-0 text-start font-weight-bold" id="products-title">Accesseries</h3>
                    <p class="text-muted">Browse our selection of accessories</p>
                </div>
            </div>
            <!-- Accessories -->
            @foreach ($accessories as $index => $accessory)
                @if ($index >= 10)
                    @break
                @endif
                <div class="col-6 col-sm-4 col-md-3 col-lg-2-4 mb-4 accessory-item" data-category-id="accessories">
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
                            <p class="mb-1 small {{ $accessory->stock_quantity > 0 ? 'text-warning' : 'text-danger' }}">
                                {!! $accessory->stock_quantity > 0
                                    ? '<i class="fas fa-check-circle me-1"></i>In stock'
                                    : '<i class="fas fa-times-circle me-1"></i>Out stock' !!}
                            </p>

                            <div class="d-flex flex-column">
                                <p class="mb-1 fw-semibold">{{ $accessory->name }}</p>
                                <p class="mb-0 text-muted small">{{ $accessory->description }}</p>
                            </div>

                            <button class="btn btn-outline-primary btn-sm mt-2 w-100 add-to-cart-btn"
                                data-id="{{ $accessory->id }}" data-name="{{ $accessory->name }}"
                                data-price="{{ $accessory->price }}"
                                data-discount="{{ $accessory->discount_percentage }}"
                                data-img="{{ asset('storage/' . $accessory->picture_url) }}"
                                data-stock="{{ $accessory->stock_quantity }}" data-barcode="{{ $accessory->barcode }}">
                                <i class="fas fa-shopping-cart me-1"></i>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>

        @include('website.shoppingcart')
    </div>
@endsection
