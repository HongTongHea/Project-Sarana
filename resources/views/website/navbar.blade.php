<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('assets/img/logo.jpg') }}" alt="" class="navbar-brand me-1" height="40">
            AngkorTech Computer</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav d-flex ms-auto me-auto fw-medium">
                <li class="nav-item"><a class="nav-link" href="{{ route('homepage.index') }}">HOME</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('productpage.index') }}">LAPTOP</a></li>
                <li class="nav-item"><a class="nav-link" href="#">PC</a></li>
                <li class="nav-item"><a class="nav-link" href="#">ACCESSORIES</a></li>
                <li class="nav-item"><a class="nav-link" href="#">ASUS</a></li>
                <li class="nav-item"><a class="nav-link" href="#">MSI</a></li>
                <li class="nav-item"><a class="nav-link" href="#">APPLE</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <button class="btn btn-outline-dark me-3" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#cartOffcanvas">
                    <i class="fas fa-shopping-cart cart-icon">
                        <span class="cart-count">0</span>
                    </i>
                </button>
                <div class="vr" style="height: 30px; width: 2px; margin-right: 10px; margin-top: 5px"></div>

            </div>
            @guest
                <a href="{{ route('login') }}" class="btn btn-primary me-2">
                    <i class="fas fa-sign-in-alt me-1"></i> Sign In
                </a>
                <a href="{{ route('register') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus me-1"></i> Sign Up
                </a>
            @endguest

            @auth
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle-start d-flex align-items-center text-decoration-none"
                        id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="me-2 d-none d-lg-inline">{{ Auth::user()->name }}</span>
                        @if (Auth::user()->picture_url)
                            <img src="{{ Storage::url(Auth::user()->picture_url) }}" alt="Profile Picture"
                                class="avatar-img rounded-5" width="40" height="40" style="object-fit: cover;">
                        @else
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-2"
                                style="width: 32px; height: 32px;">
                                <i class="fas fa-user text-white"></i>
                            </div>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i>
                                Profile</a></li>
                        @if (Auth::user()->role === 'admin')
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i
                                        class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                        @endif
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </div>
    </div>
</nav>
