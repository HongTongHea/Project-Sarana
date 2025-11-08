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
                <div class="row justify-content-end">
                    <div class="col-md-12">
                        {{-- <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Search ..." />
                        </div> --}}
                    </div>
                </div>
            </nav>
            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <i id="fullscreen-toggle" class="fa-solid fa-expand fs-5" style="cursor: pointer;"></i>
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                        aria-expanded="false">
                        <span class="profile-username text-capitalize pe-3">
                            @php
                                // Get the authenticated user from any guard
                                $user = null;
                                $guards = ['admin', 'manager', 'cashier', 'customer', 'web'];

                                foreach ($guards as $guard) {
                                    if (Auth::guard($guard)->check()) {
                                        $user = Auth::guard($guard)->user();
                                        break;
                                    }
                                }
                            @endphp

                            @if ($user)

                                <span>{{ $user->name }}</span>
                        </span>
                        <div class="avatar">
                            @if ($user->picture_url)
                                <img src="{{ Storage::url($user->picture_url) }}" alt="Profile Picture"
                                    class="avatar-img  rounded-5 oject-fit-cover object-center" width="100%">
                            @else
                                <div class="avatar-img rounded-5 d-flex align-items-center justify-content-center bg-secondary"
                                    style="width: 45px; height: 45px; color: #fff; font-size: 20px; font-weight: bold;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        @endif

                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar">
                                        @if ($user)
                                            @if ($user->picture_url)
                                                <img src="{{ Storage::url($user->picture_url) }}" alt="Profile Picture"
                                                    class="avatar-img rounded-5" width="100">
                                            @else
                                                <div class="avatar-img rounded-5 d-flex align-items-center justify-content-center bg-secondary"
                                                    style="width: 50px; height: 50px;color: #fff; font-size: 20px; font-weight: bold;">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                    </div>
                                    <div class="u-text">
                                        <h6>{{ $user->name }}</h6>
                                        <p class="text-muted">Role: {{ ucfirst($user->role) }}</p>
                                        <p class="text-muted">Email: {{ $user->email }}</p>
                                        <a href="{{ route('users.show', $user->id) }}"
                                            class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                                    </div>
                                    @endif
                                </div>
                            </li>
                            <li>
                                @if ($user)
                                    @if ($user->role === 'admin')
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
                                @endif
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>
<script>
    const fullscreenToggle = document.getElementById("fullscreen-toggle");

    fullscreenToggle.addEventListener("click", () => {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
            fullscreenToggle.classList.replace("fa-expand", "fa-compress");
        } else {
            document.exitFullscreen();
            fullscreenToggle.classList.replace("fa-compress", "fa-expand");
        }
    });

    // Optional: detect Esc key (exit fullscreen)
    document.addEventListener("fullscreenchange", () => {
        if (!document.fullscreenElement) {
            fullscreenToggle.classList.replace("fa-compress", "fa-expand");
        }
    });
</script>
