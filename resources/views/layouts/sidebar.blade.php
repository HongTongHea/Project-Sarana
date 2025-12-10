<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('admin.dashboard') }}" class="logo text-primary ">
                <img src="{{ asset('assets/img/logo-Company1.png') }}" alt="" class="navbar-brand" height="50">
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

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            @php
                // Get current user from any guard
                $user = null;
                $isAdmin = false;
                $isCashier = false;
                $isManager = false;

                // Check all guards
                $guards = ['admin', 'manager', 'cashier', 'customer', 'web'];
                foreach ($guards as $guard) {
                    if (Auth::guard($guard)->check()) {
                        $user = Auth::guard($guard)->user();
                        break;
                    }
                }

                // Determine role - FIXED: Admin and Manager are SEPARATE
                if ($user) {
                    $isAdmin = $user->role === 'admin'; // Only admin
                    $isManager = $user->role === 'manager'; // Only manager
                    $isCashier = $user->role === 'cashier'; // Only cashier
                    $isAdminOrManager = $isAdmin || $isManager; // Both admin and manager
                }
            @endphp

            <ul class="nav nav-secondary">
                <!-- Dashboard - Show to all authenticated users -->
                @if ($user)
                    <li class="nav-item active">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fa-solid fa-gauge-high"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @endif

                <!-- ADMIN & MANAGER ONLY MENU ITEMS -->
                @if ($isAdminOrManager)
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Components</h4>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}">
                            <i class="fa-solid fa-box-archive"></i>
                            <p>Categories</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('accessories.index') }}">
                            <i class="bi bi-basket2-fill"></i>
                            <p>Accessories</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('products.index') }}">
                            <i class="fa-solid fa-bag-shopping"></i>
                            <p>Products</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('stocks.index') }}">
                            <i class="fa-solid fa-boxes-stacked"></i>
                            <p>Stocks</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('suppliers.index') }}">
                            <i class="fa-solid fa-truck"></i>
                            <p>Suppliers</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('purchase_orders.index') }}">
                            <i class="fa-solid fa-receipt"></i>
                            <p>Purchases</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('customers.index') }}">
                            <i class="fa-solid fa-users-line"></i>
                            <p>Customers</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('employees.index') }}">
                            <i class="fa-solid fa-user-tie"></i>
                            <p>Employees</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('online-orders.index') }}">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <p>Orders</p>
                        </a>
                    </li>
                @endif

                <!-- SALES & TRANSACTIONS - Show to Admin, Manager, AND Cashier -->
                @if ($isAdmin || $isManager || $isCashier)
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#base2">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                            <p>Sales & Transactions</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="base2">
                            <ul class="nav nav-collapse">
                                <!-- Sale (Create New Sale) - Admin and Cashier only -->
                                @if ($isAdmin || $isCashier)
                                    <li>
                                        <a href="{{ route('sales.create') }}">
                                            <span class="sub-item">Create Sale</span>
                                        </a>
                                    </li>
                                @endif

                                <!-- Sale History - All three roles -->
                                <li>
                                    <a href="{{ route('sales.index') }}">
                                        <span class="sub-item">Sale History</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

                <!-- ADMIN & MANAGER ONLY - Reports, Contact, Users -->
                @if ($isAdmin)
                    <!-- Admin sees Reports, Contact, AND User -->
                    <li class="nav-item">
                        <a href="{{ route('sales-reports.index') }}">
                            <i class="fa-solid fa-chart-column"></i>
                            <p>Reports</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('contact.index') }}">
                            <i class="fa-solid fa-comment-dots"></i>
                            <p>Contact</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}">
                            <i class="fa-solid fa-user-gear"></i>
                            <p>User Management</p>
                        </a>
                    </li>
                @elseif ($isManager)
                    <!-- Manager sees Reports and Contact (NO User) -->
                    <li class="nav-item">
                        <a href="{{ route('sales-reports.index') }}">
                            <i class="fa-solid fa-chart-column"></i>
                            <p>Reports</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('contact.index') }}">
                            <i class="fa-solid fa-comment-dots"></i>
                            <p>Contact</p>
                        </a>
                    </li>
                    <!-- NO User menu for manager -->
                @endif

                <!-- SETTINGS/LOGOUT - Show to ALL authenticated users -->
                @if ($user)
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#base3">
                            <i class="fa-solid fa-gear"></i>
                            <p>Setting</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="base3">
                            <ul class="nav nav-collapse" style="padding-left: 20px">
                                <li class="nav-item">
                                    <form action="{{ route('logout') }}" method="POST" class="w-100">
                                        @csrf
                                        <button type="submit"
                                            class="dropdown-item d-flex align-items-center px-3 text-danger-hover"
                                            onclick="return confirm('Are you sure you want to logout?')"
                                            style="border-radius: 4px; transition: all 0.3s ease;">
                                            <i class="bi bi-escape me-3" style="font-size: 1.1rem;"></i>
                                            <span class="fw-medium" style="font-size: 0.9rem;">Logout</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <style>
        .text-danger-hover:hover {
            color: #dc3545 !important;
        }
    </style>
</div>
