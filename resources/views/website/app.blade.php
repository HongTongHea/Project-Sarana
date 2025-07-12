<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/assets/img/logo.jpg" type="image/x-icon" />
    <title>AngkorTech Computer</title>
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
    @include('website.navbar')


    @yield('content')

    <!-- Footer -->
    @include('website.footer')

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
    <script src="/assets/js/search.js"></script>
</body>

</html>
