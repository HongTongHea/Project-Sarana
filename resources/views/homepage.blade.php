<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/assets/img/logostore2.png" type="image/x-icon" />
    <title>Fashion Boutique - E-commerce</title>
    <link rel="stylesheet" href="./assets/css/website.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

</head>

<style>
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

    /* Category Card Styling */
    .category-card {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
        background: white;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .hover-effect:hover {
        background-color: #f8f9fa;
    }

    .category-icon {
        color: var(--accent-color);
        /* Use your theme color */
    }

    .text-accent {
        color: var(--accent-color);
    }

    .btn-outline-accent {
        border-color: var(--accent-color);
        color: var(--accent-color);
    }

    .btn-outline-accent:hover {
        background-color: var(--accent-color);
        color: white;
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {}
</style>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">Fashion Boutique</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav d-flex ms-auto me-auto fw-medium">
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
                    <a href="{{ route('login') }}" class="btn btn-primary me-2">Log In</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    {{-- <section class="hero-section text-center py-5">
        <div class="container">
            <h1 class="display-4 fw-bold">Summer Collection 2025</h1>
            <p class="lead">Discover our new arrivals and trendy outfits</p>
            <a href="#products-section  " class="btn btn-primary btn-lg">Shop Now</a>
        </div>
    </section> --}}
    <section>
        <div class="hero-slideshow">
    <div class="slide slide-1 active" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/img/Shoping.jpg');">
        <div class="slide-content">
            <h1 class="display-4 fw-bold">Summer Collection 2025</h1>
            <p class="lead">Discover our new arrivals and trendy outfits</p>
            <a href="#products-section" class="btn btn-primary btn-lg">Shop Now</a>
        </div>
    </div>
 <div class="slide slide-2" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/img/Shoping1.jpg');">
    <div class="slide-content">
        <h1 class="display-4 fw-bold">Beach Essentials</h1>
        <p class="lead">Everything you need for your summer getaway</p>
        <a href="#beach-collection" class="btn btn-primary btn-lg">View Collection</a>
    </div>
</div>

    <div class="slide slide-3" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/img/Shoping2.jpg');">
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


    <div class="container">
        <div class="row mb-4">
            <div class="col text-start">
                <h3 class="fw-bold">Categories</h3>
                <p class="text-muted">Browse our wide range of categories</p>
            </div>
        </div>
        <div class="row" id="categories-section">
            @foreach ($categories as $category)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2-4 mb-4">
                    <div class="card category-card h-100 border-0 shadow-sm hover-effect rounded-3 category-item"
                        data-category-id="{{ $category->id }}" style="cursor: pointer;">
                        <div class="card-body text-center d-flex flex-column justify-content-center p-3">
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
        <div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-light border-bottom">
                        <h5 class="modal-title fw-bold" id="addToCartModalLabel">
                            <i class="bi bi-bag-plus me-2"></i>Product Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
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
                                    <div class="col-md-6 mb-3" id="sizeSelectorContainer">
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
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="decreaseQty">
                                                <i class="bi bi-dash">-</i>
                                            </button>
                                            <input type="number" id="productQty" class="form-control text-center"
                                                min="1" value="1" />
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="increaseQty">
                                                <i class="bi bi-plus">+</i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancel</button>
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.slide');
            const indicators = document.querySelectorAll('.indicator');
            const prevBtn = document.querySelector('.prev-btn');
            const nextBtn = document.querySelector('.next-btn');
            let currentSlide = 0;
            let slideInterval;
            
            // Function to show a specific slide
            function showSlide(index) {
                // Hide all slides
                slides.forEach(slide => {
                    slide.classList.remove('active');
                });
                
                // Remove active class from all indicators
                indicators.forEach(indicator => {
                    indicator.classList.remove('active');
                });
                
                // Show the selected slide
                slides[index].classList.add('active');
                indicators[index].classList.add('active');
                
                currentSlide = index;
            }
            
            // Function to show the next slide
            function nextSlide() {
                let newIndex = currentSlide + 1;
                if (newIndex >= slides.length) {
                    newIndex = 0;
                }
                showSlide(newIndex);
            }
            
            // Function to show the previous slide
            function prevSlide() {
                let newIndex = currentSlide - 1;
                if (newIndex < 0) {
                    newIndex = slides.length - 1;
                }
                showSlide(newIndex);
            }
            
            // Start automatic slideshow
            function startSlideshow() {
                slideInterval = setInterval(nextSlide, 5000);
            }
            
            // Stop automatic slideshow
            function stopSlideshow() {
                clearInterval(slideInterval);
            }
            
            // Event listeners for buttons
            nextBtn.addEventListener('click', function() {
                stopSlideshow();
                nextSlide();
                startSlideshow();
            });
            
            prevBtn.addEventListener('click', function() {
                stopSlideshow();
                prevSlide();
                startSlideshow();
            });
            
            // Event listeners for indicators
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', function() {
                    stopSlideshow();
                    showSlide(index);
                    startSlideshow();
                });
            });
            
            // Start the slideshow
            startSlideshow();
        });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="/assets/js/addtocard.js"></script>
     

</body>

</html>
