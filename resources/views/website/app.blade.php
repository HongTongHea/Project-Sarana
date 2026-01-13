<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/assets/img/logo-Company2.png" type="image/x-icon" />
    <title>AngkorTech Computer</title>
    <link rel="stylesheet" href="./assets/css/website.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    @include('website.navbar')

    <!-- Content -->
    @yield('content')

    <!-- Footer -->
    @include('website.footer')

    <!-- Scripts -->



    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        const swiper = new Swiper(".heroSwiper", {
            loop: true,
            effect: "fade",
            speed: 1000,

            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },

            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });

        const rogSwiper = new Swiper(".rogBannerSwiper", {
            loop: true,
            speed: 1000,
            effect: "fade",
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".rog-main-banner .swiper-pagination",
                clickable: true,
            },
        });
    </script>

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
    </script>
    <script>
        AOS.init();
    </script>
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
