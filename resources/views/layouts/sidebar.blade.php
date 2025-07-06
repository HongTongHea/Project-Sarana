<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo text-primary ">
                <img src="{{ asset('assets/img/logo.jpg') }}" alt="" class="navbar-brand" height="30">
                <h6 class="mt-2 ms-1 text-white   " style="font-weight: 700; font-size: 14px">AngkorTech
                    <span class="text-white">Computer</span>
                </h6>
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
            <ul class="nav nav-secondary">
                <li class="nav-item active">
                    <a href="{{ route('dashboard') }}">
                        <i class="fa-solid fa-gauge-high"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
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
                    <a href="{{ route('stocks.index') }}">
                        <i class="fa-solid fa-boxes-stacked"></i>
                        <p>Stocks</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('products.index') }}">
                        <i class="fa-brands fa-product-hunt"></i>
                        <p>Products</p>
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
                    <a data-bs-toggle="collapse" href="#base2">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <p>Sales & Transactions</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="base2">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('orders.index') }}">
                                    <span class="sub-item">Order</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#base1">
                        <i class="fa-solid fa-money-check-dollar"></i>
                        <p>Sales</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="base1">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('sales.index') }}">
                                    <span class="sub-item">Sale Data</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('sales_reports.index') }}">
                                    <span class="sub-item">Sale Report</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}">
                        <i class="fa-solid fa-user-gear"></i>
                        <p>User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#base3">
                        <i class="fa-solid fa-gear"></i>
                        <p>Setting </p>
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
                                        <span class="fw-medium" style="font-size: 0.9rem;">LOGOUT</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <style>
        .text-danger-hover:hover {
            color: #dc3545 !important;
            /* Bootstrap danger color */
        }
    </style>
</div>
