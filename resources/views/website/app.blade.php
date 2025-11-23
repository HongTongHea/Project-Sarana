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

    .hero-slideshow {
        position: relative;
        margin-top: 3%;
        width: 100vw;
        height: 80vh;
        overflow: hidden;
    }

    .slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        opacity: 0;
        transition: opacity 0.8s ease-in-out;
    }

    .slide.active {
        opacity: 1;
        z-index: 1;
    }

    /* Position nav buttons */
    .slide-nav {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        display: flex;
        justify-content: space-between;
        padding: 0 20px;
        transform: translateY(-50%);
        z-index: 2;
    }

    /* Indicators at bottom */
    .slide-indicators {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
        z-index: 2;
    }

    .slide-indicators .indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        cursor: pointer;
        transition: background 0.3s;
    }

    .slide-indicators .indicator.active {
        background: white;
    }

    /* banner card */
    .rog-banner-section {
        padding: 20px 0 10px 0;

    }

    .rog-main-banner {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        height: 50%;
    }

    .rog-main-banner img {
        width: 100%;
        height: 50%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .rog-main-banner:hover img {
        transform: scale(1.05);
    }

    .rog-product-item {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .rog-product-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .rog-product-item:last-child {
        margin-bottom: 0;
    }

    .rog-product-thumb {
        flex-shrink: 0;
        width: 140px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 5px;
        padding: 10px;
    }

    .rog-product-thumb img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .rog-product-info {
        flex: 1;
    }

    .rog-product-title {
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .rog-product-price {
        font-size: 20px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .rog-product-stars {
        color: #ffc107;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .rog-buy-button {
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
        width: 100%;
    }

    .rog-buy-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 71, 87, 0.4);
        color: white;
    }

    /* Brand Section Styles */
    .brand-section {
        padding: 40px 0;
        /* Reduced from 60px */
        overflow: hidden;
    }

    .section-title {
        text-align: center;
        margin-bottom: 30px;
        /* Reduced from 40px */
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
    }

    .brand-scroller {
        position: relative;
        overflow: hidden;
        padding: 20px 0;
        background: white;
        border-radius: 15px;
    }

    .brand-scroller::before,
    .brand-scroller::after {
        content: '';
        position: absolute;
        top: 0;
        width: 100px;
        height: 100%;
        z-index: 2;
        pointer-events: none;
    }

    .brand-scroller::before {
        left: 0;
        background: linear-gradient(to right, white, transparent);
    }

    .brand-scroller::after {
        right: 0;
        background: linear-gradient(to left, white, transparent);
    }

    .brand-track {
        display: flex;
        align-items: center;
        gap: 60px;
        animation: scroll 30s linear infinite;
        width: max-content;
    }

    .brand-track:hover {
        animation-play-state: paused;
    }

    .brand-track img {
        height: 60px;
        width: auto;
        object-fit: contain;
        filter: grayscale(100%);
        opacity: 0.7;
        transition: all 0.3s ease;
    }

    .brand-track img:hover {
        filter: grayscale(0%);
        opacity: 1;
        transform: scale(1.1);
    }

    @keyframes scroll {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .rog-product-item {
            flex-direction: column;
            text-align: center;
        }

        .rog-product-thumb {
            width: 100%;
            height: 150px;
        }

        .brand-track {
            gap: 40px;
        }

        .brand-track img {
            height: 45px;
        }

        .section-title {
            font-size: 1.5rem;
        }

        .rog-banner-section {
            padding: 30px 0 15px 0;
        }

        .brand-section {
            padding: 30px 0;
        }
    }

    @media (max-width: 576px) {
        .brand-track {
            gap: 30px;
        }

        .brand-track img {
            height: 35px;
        }
    }

    @media (min-width: 769px) and (max-width: 991px) {
        .rog-product-thumb {
            width: 120px;
            height: 90px;
        }

        .rog-product-title {
            font-size: 14px;
        }

        .rog-product-price {
            font-size: 18px;
        }
    }

    @media (min-width: 992px) {
        .rog-product-item {
            min-height: 160px;
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

    /* service card */


    .service-card {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        height: 100%;
    }

    .top-right-card {
        margin-left: 20px;
    }

    .bottom-card {
        margin-left: 20px;
    }

    .service-card:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        z-index: 10;
    }

    .service-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .service-card:hover img {
        transform: scale(1.1);
        border-radius: 10px;
    }

    .service-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        color: white;
        padding: 20px;
        transform: translateY(100%);
        transition: transform 0.3s ease;
    }

    .service-card:hover .service-overlay {
        transform: translateY(0);
    }

    .left-card {
        height: 515px;
    }

    .top-right-card {
        height: 250px;
    }

    .bottom-card {
        height: 250px;
    }

    @media (max-width: 992px) {

        .left-card,
        .top-right-card,
        .bottom-card {
            margin: 0;
            height: 300px;
        }
    }

    @media (max-width: 576px) {

        .left-card,
        .top-right-card,
        .bottom-card {
            margin: 0;
            height: 200px;
        }
    }
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

</html>
