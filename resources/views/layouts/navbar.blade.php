<div class="main-header">
    <div class="main-header-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
                <img src="/assets/img/logo2.png" alt="" class="navbar-brand" height="20" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">
            <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                <div class="row">
                    <div class="p-3">
                        <i class="fa-regular fa-calendar-days"></i> <strong class="text-center fs-6"
                            id="date"></strong>
                        <i class="fa-regular fa-clock"></i> <strong class="text-center fs-6" id="time"></strong>
                    </div>
                </div>

            </nav>
            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                        aria-expanded="false">
                        <span class="profile-username text-capitalize pe-3">
                            @if (Auth::check())
                                <span class="">Welcome {{ Auth::user()->name }}</span>
                                {{-- <p class="mt-3">Role: {{ ucfirst($user->role) }}</p> --}}
                        </span>
                        <div class="avatar">
                            @if (Auth::user()->picture_url)
                                <img src="{{ Storage::url(Auth::user()->picture_url) }}" alt="Profile Picture"
                                    class="avatar-img  rounded-5 oject-fit-cover object-center" width="100%">
                            @else
                                <img src="{{ asset('assets/img/Default_pfp.svg.png') }}"class="avatar-img rounded-5"
                                    width="100">
                            @endif
                        </div>
                        @endif

                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">

                                    <div class="avatar">
                                        @if (Auth::check())
                                            @if (Auth::user()->picture_url)
                                                <img src="{{ Storage::url(Auth::user()->picture_url) }}"
                                                    alt="Profile Picture" class="avatar-img rounded-5" width="100">
                                            @else
                                                <img src="{{ asset('assets/img/Default_pfp.svg.png') }}"class="avatar-img rounded-5"
                                                    width="100">
                                            @endif

                                    </div>
                                    <div class="u-text">
                                        <h6>{{ Auth::user()->name }}</h6>
                                        <p class="text-muted">Role: {{ ucfirst(Auth::user()->role) }}</p>
                                        <p class="text-muted">Email: {{ Auth::user()->email }}</p>
                                        <a href="{{ route('users.show', Auth::user()->id) }}"
                                            class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                                    </div>
                                    @endif
                                </div>
                            </li>
                            <li>
                                @auth
                                    @if (Auth::user()->role === 'admin')
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('users.index') }}">
                                            <i class="fa-solid fa-gear"></i> Account Setting
                                        </a>
                                        <div class="dropdown-divider"></div>
                                    @endif

                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item"
                                            onclick="return confirm('Are you sure you want to logout?')">
                                            <i class="bi bi-escape"></i> Logout
                                        </button>
                                    </form>
                                @else
                                    {{-- Optionally show login link if not authenticated --}}
                                    <a class="dropdown-item" href="{{ route('login') }}">
                                        <i class="bi bi-box-arrow-in-right"></i> Login
                                    </a>
                                @endauth
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>
