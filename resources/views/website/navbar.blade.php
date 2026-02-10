<nav class="navbar navbar-expand-lg bg-light fixed-top">
    <div class="container">
        {{-- Brand --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ route('homepage.index') }}">
            <img src="{{ asset('assets/img/logo-Company.png') }}" alt="" height="50" class="me-2">
        </a>

        {{-- Toggler (only visible on mobile) --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Desktop Menu --}}
        <div class="collapse navbar-collapse d-none d-lg-flex" id="navbarNav">
            <ul class="navbar-nav ms-auto fw-bold">
                <li class="nav-item"><a class="nav-link" href="{{ route('homepage.index') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('allproductpage.index') }}">All Products</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('productpage.index') }}">Laptop & Pc</a></li>
                {{-- <li class="nav-item"><a class="nav-link" href="{{ route('') }}">Pc</a></li> --}}
                <li class="nav-item"><a class="nav-link" href="{{ route('aboutpage.index') }}">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact.create') }}">Contact Us</a></li>
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
                    <a href="{{ route('login') }}" class="btn btn-primary me-2 fw-bold">
                        <i class="fas fa-sign-in-alt me-1"></i> Sign In
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary fw-bold">
                        <i class="fas fa-user-plus me-1"></i> Sign Up
                    </a>
                @else
                    <div class="dropdown ">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                            id="userDropdownDesktop" data-bs-toggle="dropdown" aria-expanded="false">
                            {{-- Desktop Avatar --}}
                            @if ($user->picture_url)
                                <img src="{{ Storage::url($user->picture_url) }}" alt="Profile Picture"
                                    class="avatar-img rounded-5" width="40" height="40"
                                    style="object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px; font-weight: bold; color: white;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif

                        </a>
                        <ul class="dropdown-menu dropdown-menu-end mt-3" aria-labelledby="userDropdownDesktop">
                            {{-- User info at top --}}
                            <li class="dropdown-header">
                                <strong>{{ $user->name }}</strong><br>
                                <small class="text-muted">{{ $user->email }}</small>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            {{-- Role-based buttons in a row --}}
                            <li class="px-3">
                                <div class="d-flex gap-2">
                                    @if ($user->role !== 'admin')
                                        <a href="{{ route('my-orders.index') }}"
                                            class="btn btn-outline-primary d-flex align-items-center text-nowrap">
                                            <i class="bi bi-bag-check-fill me-1"></i> My Orders
                                        </a>
                                    @endif

                                    @if ($user->role === 'admin')
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="btn btn-outline-secondary d-flex align-items-center">
                                            <i class="fas fa-tachometer-alt me-1"></i> Admin
                                        </a>
                                    @elseif ($user->role === 'manager')
                                        <a href="{{ route('manager.dashboard') }}"
                                            class="btn btn-outline-secondary d-flex align-items-center">
                                            <i class="fas fa-briefcase me-1"></i> Manager
                                        </a>
                                    @elseif ($user->role === 'cashier')
                                        <a href="{{ route('cashier.dashboard') }}"
                                            class="btn btn-outline-secondary d-flex align-items-center">
                                            <i class="fas fa-cash-register me-1"></i> Cashier
                                        </a>
                                    @endif

                                    {{-- Logout --}}
                                    <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                    <a class="btn btn-danger d-flex align-items-center" href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();">
                                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                                    </a>
                                </div>
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
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="{{ asset('assets/img/logo-Company.png') }}" alt="" height="50" class="me-2">
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
                {{-- User info (Mobile) --}}
                @if (!$user)
                    <div class="mb-3 d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn btn-primary w-100 fw-bold">
                            <i class="fas fa-sign-in-alt me-1"></i> Sign In
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary w-100 fw-bold">
                            <i class="fas fa-user-plus me-1"></i> Sign Up
                        </a>
                    </div>
                    <hr>
                @endif
                @if ($user)
                    <div class="d-flex align-items-center mb-3">

                        @if ($user->picture_url)
                            <img src="{{ Storage::url($user->picture_url) }}" alt="Profile Picture"
                                class="avatar-img rounded-5 me-2" width="45" height="45"
                                style="object-fit: cover;">
                        @else
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-2"
                                style="width: 45px; height: 45px; font-weight: bold; color: white;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <strong>{{ $user->name }}</strong><br>
                            <small class="text-muted">{{ $user->email }}</small>
                        </div>
                    </div>

                    {{-- Role-based buttons --}}
                    <div class="mb-3 d-flex align-items-center justify-content-center">
                        @if ($user->role !== 'admin')
                            <a href="{{ route('my-orders.index') }}" class="btn btn-outline-primary w-100 me-2">
                                <i class="bi bi-bag-check-fill"></i> My Orders
                            </a>
                        @endif

                        @if ($user->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary w-100 me-2">
                                <i class="fas fa-tachometer-alt me-2"></i> Admin Dashboard
                            </a>
                        @elseif ($user->role === 'manager')
                            <a href="{{ route('manager.dashboard') }}" class="btn btn-outline-secondary w-100 me-2">
                                <i class="fas fa-briefcase me-2"></i> Manager Dashboard
                            </a>
                        @elseif ($user->role === 'cashier')
                            <a href="{{ route('cashier.dashboard') }}" class="btn btn-outline-secondary w-100 me-2">
                                <i class="fas fa-cash-register me-2"></i> Cashier Dashboard
                            </a>
                        @endif

                        {{-- Logout --}}
                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                        <a class="btn btn-danger py-1 w-100" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </div>
                    <hr>
                @endif

                {{-- Navigation Menu --}}
                <ul class="navbar-nav fw-bold">
                    <li class="nav-item"><a class="nav-link" href="{{ route('homepage.index') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('allproductpage.index') }}">All
                            Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('productpage.index') }}">Laptop & Pc</a>
                    </li>
                    {{-- <li class="nav-item"><a class="nav-link" href="{{ route('') }}">Pc</a></li> --}}
                    <li class="nav-item"><a class="nav-link" href="{{ route('aboutpage.index') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact.create') }}">Contact Us</a>
                    </li>
                </ul>

                {{-- Cart (Mobile) --}}
                <div class="d-flex align-items-center mt-3">
                    <button class="btn btn-outline-dark me-3" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#cartOffcanvas">
                        <i class="fas fa-shopping-cart cart-icon">
                            <span class="cart-count">0</span>
                        </i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>
