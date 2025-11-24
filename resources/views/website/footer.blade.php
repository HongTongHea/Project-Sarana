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
                    {{-- Welcom to Angkor Tech Computer Your trusted source for <br>laptops, accessories, and tech gear in Cambodia. --}}
                    Welcome to Angkor Tech Computer — your trusted technology partner in Cambodia for quality laptops,
                    accessories, and digital solutions.
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
                    <li class="mb-2"><a href="{{ route('aboutpage.index') }}"
                            class="text-white text-decoration-none">About</a></li>
                    <li class="mb-2"><a href="{{ route('contact.create') }}"
                            class="text-white text-decoration-none">Contact Us</a></li>
                </ul>
            </div>

            <!-- Social Media -->
            <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
                <h5 class="text-uppercase fw-bold mb-3">Contact Us</h5>
                <p class="small mb-1"><i class="fas fa-map-marker-alt me-2"></i>Mondul 1 Village, Sangkat Svay Dangkum,
                    Siem Reap City
                </p>
                <p class="small mb-1"><i class="fas fa-phone me-2"></i>Tel: 063 6666 777</p>
                <p class="small mb-3"><i class="fas fa-envelope me-2"></i>info@angkortechcomputer.com</p>

                <h5 class="text-uppercase fw-bold mb-3">Follow Us</h5>
                <div>
                    <a href="#" class="text-white me-3"> <i class="fa-brands fa-facebook fa-2x"
                            style="color: #3b5998;"></i></a>
                    <a href="#" class="text-white me-3"><i class="fa-brands fa-telegram fa-2x "
                            style="color: #1da1f2;"></i></a>
                    <a href="#" class="text-white me-3"><i class="fa-brands fa-instagram fa-2x "
                            style="color: #e1306c;"></i></a>
                    <a href="#" class="text-white me-3"> <i class="fa-brands fa-youtube fa-2x"
                            style="color: #0077b5;"></i></a>
                    <a href="#" class="text-white me-3"><i class="fa-brands fa-tiktok fa-2x "
                            style="color: #e1306c;"></i></a>
                </div>
            </div>
        </div>

        <hr class="border-secondary">
        <!-- Copyright -->
        <div class="text-center">
            <p class="mb-0 small">
                &copy; {{ date('Y') }} <strong>Angkor Tech Computer</strong>. All rights reserved.
            </p>
        </div>
    </div>
</footer>
