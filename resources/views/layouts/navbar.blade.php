<div class="main-header">
    <div class="main-header-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
                <img src="/assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20" />
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
                    <div class="col-12">
                        <i class="fa-regular fa-calendar-days"></i> <strong class="text-center fs-6" id="date"></strong>
                    </div>
                    <div class="col-12">
                        <i class="fa-regular fa-clock"></i> <strong class="text-center fs-6" id="time"></strong>
                    </div>
                </div>

            </nav>
            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                    {{-- <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                        aria-expanded="false" aria-haspopup="true">
                   
                    </a> --}}
                    {{-- <ul class="dropdown-menu dropdown-search animated fadeIn">
                      x
                    </ul> --}}

                </li>


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
                                                    alt="Profile Picture" class="avatar-img rounded-5"
                                                    width="100">
                                            @endif

                                    </div>
                                    <div class="u-text">
                                        <h6>{{ Auth::user()->name }}</h6>
                                        <p class="text-muted">Role: {{ ucfirst(Auth::user()->role) }}</p>
                                        <a href="{{ route('users.show', Auth::user()->id) }}" class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                                    </div>
                                    @endif
                                </div>
                            </li>
                            <li>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('users.index') }}"><i class="fa-solid fa-gear"></i> Account Setting</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('login') }}"><i class="fa-solid fa-arrow-right-to-bracket"></i> Login</a>
                                <a class="dropdown-item" href="{{ route('register') }}"><i class="bi bi-r-circle"></i> Register</a>
                                <form action="{{ route('logout') }}" method="POST" class="">
                                    @csrf
                                    <button type="submit" class="dropdown-item"> <i class="bi bi-escape"></i> Logout</button>
                                </form>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>
