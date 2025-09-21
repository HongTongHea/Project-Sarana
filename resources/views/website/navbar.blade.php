<nav class="navbar navbar-expand-lg bg-light fixed-top">
    <div class="container">
        {{-- Brand --}}
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('assets/img/logo.jpg') }}" alt="" height="40" class="me-2">
            AngkorTech Computer
        </a>

        {{-- Toggler (only visible on mobile) --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Desktop Menu --}}
        <div class="collapse navbar-collapse d-none d-lg-flex" id="navbarNav">
            <ul class="navbar-nav ms-auto fw-bold">
                <li class="nav-item"><a class="nav-link" href="{{ route('homepage.index') }}">HOME</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('allproductpage.index') }}">All PRODUCTS</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('productpage.index') }}">LAPTOP</a></li>
                <li class="nav-item"><a class="nav-link" href="#">PC</a></li>
                <li class="nav-item"><a class="nav-link" href="#">ABOUT</a></li>
                <li class="nav-item"><a class="nav-link" href="#">CONTACT US</a></li>
            </ul>

            {{-- Cart + Auth (Desktop) --}}
            <div class="d-flex align-items-center ms-3">
                {{-- Cart Button --}}
                <button class="btn btn-outline-dark me-3" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#cartOffcanvas">
                    <i class="fas fa-shopping-cart cart-icon">
                        <span class="cart-count">0</span>
                    </i>
                </button>

                {{-- User Authentication --}}
                @php
                    $user =
                        Auth::guard('admin')->user() ??
                        (Auth::guard('manager')->user() ??
                            (Auth::guard('cashier')->user() ?? (Auth::guard('customer')->user() ?? Auth::user())));
                @endphp

                @if (!$user)
                    <a href="{{ route('login') }}" class="btn btn-primary me-2">
                        <i class="fas fa-sign-in-alt me-1"></i> Sign In
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus me-1"></i> Sign Up
                    </a>
                @else
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                            id="userDropdownDesktop" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="me-2">{{ $user->name }}</span>
                            @if ($user->picture_url)
                                <img src="{{ Storage::url($user->picture_url) }}" alt="Profile Picture"
                                    class="avatar-img rounded-5" width="40" height="40"
                                    style="object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 32px; height: 32px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdownDesktop">
                            @if ($user->role !== 'admin')
                                <li><a class="dropdown-item" href="{{ route('profile') }}">
                                        <i class="fas fa-gear me-2"></i> Setting
                                    </a></li>
                            @endif
                            @if ($user->role === 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i> Admin Dashboard
                                    </a></li>
                            @elseif ($user->role === 'manager')
                                <li><a class="dropdown-item" href="{{ route('manager.dashboard') }}">
                                        <i class="fas fa-briefcase me-2"></i> Manager Dashboard
                                    </a></li>
                            @elseif ($user->role === 'cashier')
                                <li><a class="dropdown-item" href="{{ route('cashier.dashboard') }}">
                                        <i class="fas fa-cash-register me-2"></i> Cashier Dashboard
                                    </a></li>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                                <a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        {{-- Mobile Offcanvas --}}
        <div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav fw-bold">
                    <li class="nav-item"><a class="nav-link" href="{{ route('homepage.index') }}">HOME</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('allproductpage.index') }}">All
                            PRODUCTS</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('productpage.index') }}">LAPTOP</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">PC</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">ABOUT</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">CONTACT US</a></li>
                </ul>

                {{-- Cart & Auth (Mobile Offcanvas) --}}
                <div class="mt-3">
                    <button class="btn btn-outline-dark me-3" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#cartOffcanvas">
                        <i class="fas fa-shopping-cart cart-icon">
                            <span class="cart-count">0</span>
                        </i>
                    </button>
                </div>

                <div class="mt-3">
                    @if (!$user)
                        <a href="{{ route('login') }}" class="btn btn-primary me-2">
                            <i class="fas fa-sign-in-alt me-1"></i> Sign In
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus me-1"></i> Sign Up
                        </a>
                    @else
                        <div class="dropdown mt-3">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                                id="userDropdownMobile" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="me-2">{{ $user->name }}</span>
                                @if ($user->picture_url)
                                    <img src="{{ Storage::url($user->picture_url) }}" alt="Profile Picture"
                                        class="avatar-img rounded-5" width="40" height="40"
                                        style="object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 32px; height: 32px;">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdownMobile">
                                @if ($user->role !== 'admin')
                                    <li><a class="dropdown-item" href="{{ route('profile') }}">
                                            <i class="fas fa-gear me-2"></i> Setting
                                        </a></li>
                                @endif
                                @if ($user->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-tachometer-alt me-2"></i> Admin Dashboard
                                        </a></li>
                                @elseif ($user->role === 'manager')
                                    <li><a class="dropdown-item" href="{{ route('manager.dashboard') }}">
                                            <i class="fas fa-briefcase me-2"></i> Manager Dashboard
                                        </a></li>
                                @elseif ($user->role === 'cashier')
                                    <li><a class="dropdown-item" href="{{ route('cashier.dashboard') }}">
                                            <i class="fas fa-cash-register me-2"></i> Cashier Dashboard
                                        </a></li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</nav>
