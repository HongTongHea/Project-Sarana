<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo text-primary ms-2 ">
                <i class="fa-solid fa-store"></i>
                <h6 class="text-uppercase mt-2 ms-1 text-primary    " style="font-weight: 700; font-size: 16px">Clothes <span class="text-warning">Store</span>
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
    @if (Auth::user()->role == 'admin')
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
                        <a href="{{route('categories.index')}}">
                            <i class="fas fa-layer-group"></i>
                            <p>Categories</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('products.index')}}">
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
                        <a href="{{ route('customers.index') }}">
                            <i class="fa-solid fa-address-card"></i>
                            <p>Staffs</p>
                        </a>
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
                                    <a href="">
                                        <span class="sub-item">Sale List</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <span class="sub-item">Sale Report</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#base2">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <p>Orders</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="base2">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{route('orders.index')}}">
                                        <span class="sub-item">Order List</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('orderItems.index') }}">
                                        <span class="sub-item">Order Items</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>


                    <li class="nav-item">
                        <a href="widgets.html">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                            <p>Payments</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}">
                            <i class="fa-solid fa-user-gear"></i>
                            <p>User</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    @elseif (Auth::user()->role == 'customer')
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
                        <a href="{{ route('customers.index') }}">
                            <i class="fa-solid fa-users-line"></i>
                            <p>Customers</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#base2">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <p>Orders</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="base2">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{route('orders.index')}}">
                                        <span class="sub-item">Order List</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('orders.items', $order->id) }}">
                                        <span class="sub-item">Order Items</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>


                    <li class="nav-item">
                        <a href="widgets.html">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                            <p>Payments</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    @elseif (Auth::user()->role == 'staff')
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
                        <a href="">
                            <i class="fas fa-layer-group"></i>
                            <p>Categories</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="">
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
                        <a href="{{ route('customers.index') }}">
                            <i class="fa-solid fa-address-card"></i>
                            <p>Staffs</p>
                        </a>
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
                                    <a href="">
                                        <span class="sub-item">Sale List</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <span class="sub-item">Sale Report</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="widgets.html">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                            <p>Payments</p>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    @endif

</div>
