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
                <!-- Notification Bell -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle position-relative" href="#" id="notificationDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-bell fs-5"></i>
                        @php
                            $unreadCount = \App\Models\Contact::where('read_status', false)->count();
                        @endphp
                        @if ($unreadCount > 0)
                            <span
                                class="position-absolute top-0 start-75 translate-middle badge rounded-pill bg-danger">
                                {{ $unreadCount }}
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-notification"
                        aria-labelledby="notificationDropdown">
                        <li class="dropdown-header">
                            <h6 class="mb-0">Notifications</h6>
                            @if ($unreadCount > 0)
                                <span class="badge bg-primary">{{ $unreadCount }} unread</span>
                            @endif
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        @php
                            $recentContacts = \App\Models\Contact::latest()->take(5)->get();
                        @endphp

                        @if ($recentContacts->count() > 0)
                            @foreach ($recentContacts as $contact)
                                <li>
                                    <a class="dropdown-item d-flex align-items-center notification-item {{ !$contact->read_status ? 'unread' : '' }}"
                                        href="{{ route('contact.index') }}" data-contact-id="{{ $contact->id }}">
                                        <div class="notification-icon me-3">
                                            <i
                                                class="fa-solid fa-envelope {{ !$contact->read_status ? 'text-primary' : 'text-muted' }}"></i>
                                        </div>
                                        <div class="notification-content flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <strong>{{ $contact->name }}</strong>
                                                <small
                                                    class="text-muted">{{ $contact->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-0 text-truncate" style="max-width: 250px;">
                                                {{ Str::limit($contact->message, 50) }}
                                            </p>
                                            <small class="text-muted">{{ $contact->email }}</small>
                                        </div>
                                    </a>
                                </li>
                                @if (!$loop->last)
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                @endif
                            @endforeach
                        @else
                            <li>
                                <div class="dropdown-item text-center text-muted py-3">
                                    <i class="fa-solid fa-bell-slash fs-4 mb-2"></i>
                                    <p class="mb-0">No notifications</p>
                                </div>
                            </li>
                        @endif

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-center text-primary" href="{{ route('contact.index') }}">
                                <i class="fa-solid fa-eye me-2"></i>View All Messages
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Fullscreen Toggle -->
                <li class="nav-item">
                    <i id="fullscreen-toggle" class="fa-solid fa-expand fs-5"
                        style="cursor: pointer; color: #6c757d; padding: 8px 12px;" title="Toggle Fullscreen"></i>
                </li>

                <!-- User Profile Dropdown -->
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
                                    class="avatar-img rounded-5 oject-fit-cover object-center" width="100%">
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
<style>
    /* Notification Styles */
    .dropdown-notification {
        width: 350px;
        max-height: 400px;
        overflow-y: auto;
    }

    .notification-item {
        padding: 10px 15px;
        transition: all 0.3s ease;
        border-radius: 5px;
    }

    .notification-item:hover {
        background-color: #f8f9fa;
    }

    .notification-item.unread {
        background-color: #e7f1ff;
        border-left: 3px solid #007bff;
    }

    .notification-item.unread:hover {
        background-color: #d8e7ff;
    }

    .notification-icon {
        width: 30px;
        text-align: center;
    }

    .notification-content {
        min-width: 0;
    }

    .badge {
        font-size: 0.7em;

    }

    .dropdown-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
        background-color: #f8f9fa;
    }

    /* Navbar icon animations */
    .nav-link .fa-bell {
        transition: all 0.3s ease;
    }

    .nav-link:hover .fa-bell {
        color: #007bff;
        transform: scale(1.1);
    }

    /* Pulse animation for unread notifications */
    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }

    .badge.bg-danger {
        animation: pulse 2s infinite;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .dropdown-notification {
            width: 300px;
            right: -50px !important;
        }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mark notification as read when clicked
        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', function(e) {
                const contactId = this.getAttribute('data-contact-id');

                // Mark as read via AJAX
                if (contactId) {
                    fetch(`/admin/contacts/${contactId}/mark-read`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                _method: 'PUT'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.classList.remove('unread');
                                updateNotificationCount();
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
        });

        // Update notification count
        function updateNotificationCount() {
            fetch('{{ route('contact.unread-count') }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.querySelector('.nav-link .badge');
                    if (data.unread_count > 0) {
                        if (badge) {
                            badge.textContent = data.unread_count;
                        } else {
                            createBadge(data.unread_count);
                        }
                    } else {
                        if (badge) {
                            badge.remove();
                        }
                    }
                });
        }

        function createBadge(count) {
            const bellIcon = document.querySelector('.nav-link .fa-bell');
            const badge = document.createElement('span');
            badge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger';
            badge.textContent = count;
            badge.innerHTML += '<span class="visually-hidden">unread messages</span>';
            bellIcon.parentNode.appendChild(badge);
        }

        // Check for new notifications every 30 seconds
        setInterval(updateNotificationCount, 30000);

        // Fullscreen toggle functionality
        const fullscreenToggle = document.getElementById('fullscreen-toggle');
        if (fullscreenToggle) {
            fullscreenToggle.addEventListener('click', function() {
                if (!document.fullscreenElement) {
                    if (document.documentElement.requestFullscreen) {
                        document.documentElement.requestFullscreen();
                    } else if (document.documentElement.webkitRequestFullscreen) {
                        document.documentElement.webkitRequestFullscreen();
                    } else if (document.documentElement.msRequestFullscreen) {
                        document.documentElement.msRequestFullscreen();
                    }
                    fullscreenToggle.classList.remove('fa-expand');
                    fullscreenToggle.classList.add('fa-compress');
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    } else if (document.webkitExitFullscreen) {
                        document.webkitExitFullscreen();
                    } else if (document.msExitFullscreen) {
                        document.msExitFullscreen();
                    }
                    fullscreenToggle.classList.remove('fa-compress');
                    fullscreenToggle.classList.add('fa-expand');
                }
            });

            // Listen for fullscreen change events to update icon
            document.addEventListener('fullscreenchange', updateFullscreenIcon);
            document.addEventListener('webkitfullscreenchange', updateFullscreenIcon);
            document.addEventListener('msfullscreenchange', updateFullscreenIcon);

            function updateFullscreenIcon() {
                if (document.fullscreenElement ||
                    document.webkitFullscreenElement ||
                    document.msFullscreenElement) {
                    fullscreenToggle.classList.remove('fa-expand');
                    fullscreenToggle.classList.add('fa-compress');
                } else {
                    fullscreenToggle.classList.remove('fa-compress');
                    fullscreenToggle.classList.add('fa-expand');
                }
            }

            // Add hover effects
            fullscreenToggle.addEventListener('mouseenter', function() {
                this.style.color = '#007bff';
                this.style.transform = 'scale(1.1)';
            });

            fullscreenToggle.addEventListener('mouseleave', function() {
                this.style.color = '#6c757d';
                this.style.transform = 'scale(1)';
            });
        }
    });
</script>
