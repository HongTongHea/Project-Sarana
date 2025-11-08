<footer class="bg-dark text-white pt-5 pb-4">
    <div class="container text-md-left">
        <div class="row text-md-left">

            <!-- Company Info -->
            <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
                <a class="navbar-brand d-flex align-items-center mb-3" href="#">
                    <img src="{{ asset('assets/img/logo-Company1.png') }}" alt="Logo" height="50" class="me-2">
                    {{-- <span class="fw-bold">AngkorTech Computer</span> --}}
                </a>
                <p class="small">
                    Your trusted source for laptops, accessories, <br>and tech gear in Cambodia.
                </p>
                <p class="text-start text-uppercase fw-bold">We accept payment:</p>
                <div class="d-flex  align-items-center">
                    <img src="assets/img/KH-QR.png" alt="" class="me-2" style="height: 50px; width: auto;">
                    <img src="assets/img/ABA.png" alt="" class="me-2" style="height: 50px; width: auto;">
                    <img src="assets/img/ACLEDA.jpg" alt="" class="me-2" style="height: 50px; width: auto;">
                    <img src="assets/img/VISA.jpg" alt="" class="me-2" style="height: 50px; width: auto;">
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
                <h5 class="text-uppercase fw-bold mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('homepage.index') }}"
                            class="text-white text-decoration-none">Home</a></li>
                    <li class="mb-2"><a href="{{ route('allproductpage.index') }}"
                            class="text-white text-decoration-none">All Products</a></li>
                    <li class="mb-2"><a href="{{ route('productpage.index') }}"
                            class="text-white text-decoration-none">Laptop</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">About</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none">Contact Us</a></li>
                </ul>
            </div>

            <!-- Social Media -->
            <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
                <h5 class="text-uppercase fw-bold mb-3">Contact Us</h5>
                <p class="small mb-1"><i class="fas fa-map-marker-alt me-2"></i>123 Tech Street, Phnom Penh, Cambodia
                </p>
                <p class="small mb-1"><i class="fas fa-phone me-2"></i>+855 123 456 789</p>
                <p class="small mb-3"><i class="fas fa-envelope me-2"></i>info@angkortechcomputer.com</p>

                <h5 class="text-uppercase fw-bold mb-3">Follow Us</h5>
                <div>
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-telegram fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-youtube fa-lg"></i></a>
                </div>
            </div>
        </div>
        {{-- <div class="d-flex justify-content-center align-items-center">
            <p class="text-center m-2">We accept payment:</p>
            <img src="assets/img/KH-QR.png" alt="" style="height: 50px; width: auto;">
            <img src="assets/img/ABA.png" alt="" style="height: 65px; width: auto;">
            <img src="assets/img/mastercard.png" alt="" style="height: 50px; width: auto;">

        </div> --}}

        <hr class="border-secondary">
        <!-- Copyright -->
        <div class="text-center">
            <p class="mb-0 small">
                &copy; {{ date('Y') }} <strong>AngkorTech Computer</strong>. All rights reserved.
            </p>
        </div>
    </div>
</footer>
