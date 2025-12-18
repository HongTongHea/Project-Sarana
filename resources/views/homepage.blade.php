@extends('website.app')
@section('title', 'ANGKOR TECH COMPUTER | Home Page')
@section('content')
    {{-- Hero Section --}}
    <section>
        <div class="hero-slideshow">
            <div class="slide slide-1 active" style="background-image: url('assets/img/slide (9).png');">
            </div>
            <div class="slide slide-2" style="background-image: url('assets/img/slide (6).png');">
            </div>
            <div class="slide slide-3" style="background-image: url('assets/img/slide (7).png');">
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
                {{-- @if ($index >= 5)
                    @break
                @endif --}}
                <div class="col-6 col-sm-4 col-md-4 col-lg-2-4 mb-5">
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
            <div class="d-flex justify-content-between align-items-center">
                <div class="row mb-2">
                    <div class="col text-start">
                        <h3 class="mb-0 text-start fw-bold" id="products-title">Products</h3>
                        <p class="text-muted">Browse our selection of Products</p>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <button class="btn btn-outline-primary btn-sm" id="see-all-btn" style="display: none;">See All</button>
                    {{-- <button class="btn btn-outline-primary mt-2" onclick="resetProductFilter()">
                        View All Products
                    </button> --}}
                </div>
            </div>
            <div class="row" id="products-container">
                @foreach ($products->sortByDesc('created_at')->values() as $index => $product)
                    @if ($index >= 20)
                        @break
                    @endif
                    <div class="col-6 col-sm-4 col-md-4 col-lg-2-4 mb-4 product-item"
                        data-category-id="{{ $product->category_id }}">

                        <div class="card border-0 position-relative product-card">

                            @if ($product->created_at->gt(now()->subDays(7)))
                                <span class="badge bg-primary position-absolute top-0 end-0 m-2 z-3">
                                    NEW
                                </span>
                            @endif
                            @if ($product->discount_percentage > 0)
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2 z-3">
                                    -{{ $product->discount_percentage }}%
                                </span>
                            @endif

                            <div class="overflow-hidden product-image-container position-relative">
                                @if ($product->picture_url)
                                    <img src="{{ asset('storage/' . $product->picture_url) }}" alt="{{ $product->name }}"
                                        class="card-img-top img-fluid product-image">
                                @else
                                    <img src="{{ asset('assets/img/image.png') }}"
                                        class="card-img-top img-fluid product-image">
                                @endif

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
                <div id="no-products-message" class="col-12 text-center py-2 d-none">
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-search fa-2x mb-3"></i>
                        <h4>No Products Found</h4>
                        <p>There are no products available in this category.</p>
                    </div>
                </div>
            </div>


        </section>
        <!-- ROG Banner Section -->
        <section class="rog-banner-section ">
            <div class="container py-4">
                <div class="row g-4">
                    <!-- Left Side (Big Banner) -->
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <div class="rog-banner-wrapper">
                            <div class="rog-main-banner">
                                <img src="{{ asset('assets/victor/asus_rog.jpg') }}" alt="acer predator"
                                    style="height: 340px">
                            </div>
                        </div>
                    </div>

                    <!-- Right Side (Products) -->
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <div class="rog-products-wrapper">
                            <div class="row g-3">
                                @foreach ($products->sortByDesc('created_at')->values() as $index => $product)
                                    @if ($index >= 2)
                                        @break
                                    @endif

                                    <div class="col-6 col-md-6 col-lg-12">
                                        <div class="rog-product-item position-relative product-card">

                                            @if ($product->created_at->gt(now()->subDays(7)))
                                                <span
                                                    class="badge bg-primary position-absolute top-0 start-0 m-2 z-3">NEW</span>
                                            @endif

                                            <div class="rog-product-thumb">
                                                @if ($product->picture_url)
                                                    <img src="{{ asset('storage/' . $product->picture_url) }}"
                                                        alt="{{ $product->name }}"
                                                        class="card-img-top img-fluid product-image">
                                                @else
                                                    <img src="{{ asset('assets/img/image.png') }}"
                                                        class="card-img-top img-fluid product-image">
                                                @endif
                                            </div>

                                            <div class="rog-product-info">
                                                <h6 class="rog-product-title">{{ $product->name }}</h6>

                                                @if ($product->discount_percentage > 0)
                                                    <div class="rog-product-price text-danger fw-bold">
                                                        ${{ number_format($product->price - ($product->price * $product->discount_percentage) / 100, 2) }}
                                                        <small class="text-muted text-decoration-line-through">
                                                            ${{ number_format($product->price, 2) }}
                                                        </small>
                                                    </div>
                                                @else
                                                    <div class="rog-product-price fw-bold">
                                                        ${{ number_format($product->price, 2) }}
                                                    </div>
                                                @endif

                                                <a href="{{ route('allproductpage.index') }}"
                                                    class="rog-buy-button add-to-cart-btn btn btn-primary">Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
        </section>

        <!-- Brand Scrolling Section -->
        <div class="brand-section mt-2 mb-2">
            <div class="container">
                <h2 class="mb-0 text-center fw-bold text-black mt-5">Our Branding</h2>
                <p class="text-muted text-center">Discover a wide range of top-notch products from our trusted brands</p>
                <div class="brand-scroller">
                    <div class="brand-track">
                        <img src="{{ asset('assets/logo/dell-logo.png') }}" alt="Dell",
                            style="height: 30px; width: auto;">
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

        <!-- Accessories Section -->
        <section>
            <div class="row mb-2 mt-2">
                <div class="col text-start">
                    <h3 class="mb-0 text-start fw-bold">Accessories</h3>
                    <p class="text-muted">Browse our selection of accessories</p>
                </div>
            </div>
            <div class="row" id="accessories-container">
                @foreach ($accessories->sortByDesc('created_at')->values() as $index => $accessory)
                    @if ($index >= 20)
                        @break
                    @endif
                    <div class="col-6 col-sm-4 col-md-4 col-lg-2-4 accessory-item">
                        <div class="card border-0 position-relative product-card">
                            @if ($accessory->created_at->gt(now()->subDays(7)))
                                <span class="badge bg-primary position-absolute top-0 end-0 m-2 z-3">
                                    NEW
                                </span>
                            @endif
                            @if ($accessory->discount_percentage > 0)
                                <span
                                    class="badge bg-danger position-absolute top-0 start-0 m-2 z-3">-{{ $accessory->discount_percentage }}%</span>
                            @endif
                            <div class="overflow-hidden product-image-container position-relative">
                                @if ($accessory->picture_url)
                                    <img src="{{ asset('storage/' . $accessory->picture_url) }}"
                                        alt="{{ $accessory->name }}" class="card-img-top img-fluid product-image">
                                @else
                                    <img src="{{ asset('assets/img/image.png') }}"
                                        class="card-img-top img-fluid product-image">
                                @endif
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
                                    data-stock="{{ $accessory->stock_quantity }}"
                                    data-barcode="{{ $accessory->barcode }}"
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

        <section>
            <div class="container mt-5 mb-5">
                <div class="service-section">
                    <div class="row mt-2">
                        <div class="col text-start">
                            <h3 class="mb-0 text-start fw-bold">Our Services</h3>
                            <p class="text-muted">Explore our range of services</p>
                        </div>
                    </div>

                    <div class="row g-0 mt-3">
                        <!-- Left Large Card -->
                        <div class="col-lg-6">
                            <div class="service-card left-card mb-2">
                                <img src="{{ asset('assets/victor/camera-installation-2.jpg') }}" alt="Plumbing Service">
                                <div class="service-overlay">
                                    <h4>Plumbing Services</h4>
                                    <p>Professional plumbing installation and repair services</p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side Column -->
                        <div class="col-lg-6 ml-2">
                            <!-- Top Right Card -->
                            <div class="row g-0">
                                <div class="col-12">
                                    <div class="service-card top-right-card">
                                        <img src="{{ asset('assets/victor/custome_pc.png') }}" alt="Gaming PC Setup">
                                        <div class="service-overlay">
                                            <h4>Gaming PC Setup</h4>
                                            <p>Custom gaming stations with premium peripherals</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bottom Two Cards -->
                            <div class="row g-2 mt-2">
                                <div class="col-6 col-md-6">
                                    <div class="service-card bottom-card">
                                        <img src="{{ asset('assets/victor/build_system.png') }}" alt="Custom PC Build">
                                        <div class="service-overlay">
                                            <h5>Custom PC Build</h5>
                                            <p>High-performance builds</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="service-card bottom-card">
                                        <img src="{{ asset('assets/victor/build_system_unite.png') }}"
                                            alt="RGB Gaming Rigs">
                                        <div class="service-overlay">
                                            <h5>RGB Gaming Rigs</h5>
                                            <p>Premium lighting setups</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('website.shoppingcart')
    </div>

    <div id="cartToastContainer" class="toast-container position-fixed top-0 end-0 p-3"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Store initial state
            const initialProductCount = {{ $products->count() }};
            const initialAccessoryCount = {{ $accessories->count() }};
            const initialProductUpdate = '{{ $products->max('updated_at') }}';
            const initialAccessoryUpdate = '{{ $accessories->max('updated_at') }}';

            // Check every 10 seconds
            setInterval(function() {
                fetch('{{ route('check.updates') }}', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Check for INSERT (count changed)
                        const countChanged = data.productCount !== initialProductCount ||
                            data.accessoryCount !== initialAccessoryCount;

                        // Check for UPDATE (timestamp changed)
                        const productUpdated = data.latestProductUpdate !== initialProductUpdate;
                        const accessoryUpdated = data.latestAccessoryUpdate !== initialAccessoryUpdate;

                        // Refresh if anything changed
                        if (countChanged || productUpdated || accessoryUpdated) {
                            location.reload();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }, 10000); // Check every 10 seconds
        });
    </script>
@endsection
