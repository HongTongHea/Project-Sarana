<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/assets/img/logo-Company2.png" type="image/x-icon" />
    <title>AngkorTech Computer</title>
    <link rel="stylesheet" href="./assets/css/website.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

</head>

<body>
    <!-- Navbar -->
    @include('website.navbar')

    <!-- Content -->
    @yield('content')

    <!-- Footer -->
    @include('website.footer')

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get current page URL
            const currentUrl = window.location.href;

            // Select all navigation links in both desktop and mobile menus
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

            navLinks.forEach(link => {
                // Remove active class from all links first
                link.classList.remove('active');

                // Check if this link's href matches current URL
                if (link.href === currentUrl) {
                    link.classList.add('active');
                }

                // For routes with parameters or slightly different URLs, 
                // you might need more sophisticated matching
                const linkPath = new URL(link.href).pathname;
                const currentPath = window.location.pathname;

                // Additional check for better route matching
                if (linkPath === currentPath && linkPath !== '/') {
                    link.classList.add('active');
                }
            });

            // Special case for homepage
            if (window.location.pathname === '/') {
                const homeLinks = document.querySelectorAll('a[href="{{ route('homepage.index') }}"]');
                homeLinks.forEach(link => link.classList.add('active'));
            }
        });

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
        // side baner
        const customSlides = document.querySelector('.custom-slides');
        const totalSlides = document.querySelectorAll('.custom-slide').length;
        let customIndex = 0;

        document.querySelector('.custom-next-btn').addEventListener('click', () => {
            customIndex = (customIndex + 1) % totalSlides;
            updateSlide();
        });

        // document.querySelector('.custom-prev-btn').addEventListener('click', () => {
        //     customIndex = (customIndex - 1 + totalSlides) % totalSlides;
        //     updateSlide();
        // });

        function updateSlide() {
            const offset = -customIndex * 100;
            customSlides.style.transform = `translateX(${offset}%)`;
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/addtocard.js"></script>
    <script src="/assets/js/search.js"></script>
</body>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        overflow-x: hidden;
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
</style>

</html>
