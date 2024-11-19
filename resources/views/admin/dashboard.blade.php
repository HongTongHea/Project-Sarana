@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mt-3" data-aos="fade-down" data-aos-duration="1000">

        @if (Auth::user()->role === 'admin')
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold m-3  mb-0 mt-0">Dashboard</h3>
                    <h6 class="op-7 m-3">! Hey Admin Dashboard</h6>
                </div>
                <div class="ms-md-auto py-2 py-md-0">
                    <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                    <a href="{{ route('users.index') }}" class="btn btn-primary btn-round">Add User</a>
                </div>
            </div>
        @elseif(Auth::user()->role === 'customer')
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold m-3  mb-0 mt-0">Dashboard</h3>
                    <h6 class="op-7 m-3">! Hey Customer Dashboard</h6>
                </div>
                <div class="ms-md-auto py-2 py-md-0">
                    <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                    <a href="{{ route('customers.create') }}" class="btn btn-primary btn-round">Add Customer</a>
                </div>
            </div>
        @else
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold m-3  mb-0 mt-0">Dashboard</h3>
                    <h6 class="op-7 m-3">! Hey Staffs Dashboard</h6>
                </div>
                <div class="ms-md-auto py-2 py-md-0">
                    <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                    <a href="{{ route('customers.create') }}" class="btn btn-primary btn-round">Add Customer</a>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-user-check"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">User</p>
                                    <h4 class="card-title">{{ $users->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Customers</p>
                                    <h4 class="card-title">{{ $customers->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fa-solid fa-dollar-sign"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Sales</p>
                                    <h4 class="card-title">${{ $sales->sum('total_price') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="far fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Order</p>
                                    <h4 class="card-title">{{ $orders->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fa-solid fa-address-card"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Staffs</p>
                                    <h4 class="card-title">{{ $staffs->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fa-solid fa-boxes-stacked"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Stocks</p>
                                    <h4 class="card-title">{{ $stocks->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fa-solid fa-box-archive"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Categories</p>
                                    <h4 class="card-title">{{ $categories->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fa-brands fa-product-hunt"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Products</p>
                                    <h4 class="card-title">{{ $products->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            @if (Auth::user()->role === 'admin')
                <div class="col-12 col-md-12">
                    <div class="card mt-3 mx-2">
                        <div class="card-body">
                            <div class="row m-2 align-items-center">
                                <div class="col-8 p-0">
                                    <h3 class="m-3">User Data</h3>
                                </div>
                                <div class="col-4">
                                    <div class="row align-items-center">
                                        <div class="input-group rounded-5">
                                            <input type="text" id="search" placeholder="Search ..."
                                                class="form-control rounded-4 border position-relative" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-sm table-hover mt-3  search-table" id="UserTableData">
                                    <thead>
                                        <tr>
                                            <th>Profile</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Actions</th>
                                        </tr>

                                    </thead>
                                    <tbody id="tableBody">
                                        @foreach ($users as $index => $user)
                                            <tr>
                                                <td>
                                                    @if ($user->picture_url)
                                                        <img src="{{ asset('storage/' . $user->picture_url) }}"
                                                            alt="{{ $user->name }}"
                                                            class="avatar-img avatar-lg rounded-5 object-fit-cover object-center"
                                                            width="100">
                                                    @else
                                                        No picture
                                                    @endif
                                                </td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ ucfirst($user->role) }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-warning btn-sm dropdown-toggle rounded-5"
                                                            type="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">Action</button>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="{{ route('users.show', $user->id) }}"
                                                                    class="dropdown-item">User Detail</a></li>
                                                            <li><a href="{{ route('users.index', ['edit' => $user->id]) }}"
                                                                    class="dropdown-item">Edit</a></li>
                                                            <li>
                                                                <form action="{{ route('users.destroy', $user->id) }}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item"
                                                                        onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-Start mb-3 ">
                                    <button id="prevBtn" class="btn border btn-sm me-2 rounded-5 border-dark txt-dark"
                                        onclick="prevPage()" disabled><i class="fa-solid fa-angle-left"></i>
                                        Previous</button>
                                    <button id="nextBtn" class="btn border btn-sm rounded-5 border-dark txt-dark"
                                        onclick="nextPage()">Next <i class="fa-solid fa-angle-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12">
                    <div class="card mt-3 mx-2">
                        <div class="card-body">
                            <div class="row m-2 align-items-center">
                                <div class="col-8 p-0">
                                    <h3 class="m-3">Customer Data</h3>
                                </div>
                                <div class="col-4">
                                    <div class="row align-items-center">
                                     
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mt-3 search-table" id="Table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Gender</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>

                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        @foreach ($customers as $customer)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $customer->first_name }}</td>
                                                <td>{{ $customer->last_name }}</td>
                                                <td>{{ $customer->gender }}</td>
                                                <td>{{ $customer->email }}</td>
                                                <td>{{ $customer->phone }}</td>
                                                <td>{{ $customer->address }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif (Auth::user()->role === 'customer')
                <div class="col-12 col-md-12">
                    <div class="card mt-3 mx-2">
                        <div class="card-body">
                            <div class="row m-2 align-items-center">
                                <div class="col-8 p-0">
                                    <h3 class="m-3">Customer Data</h3>
                                </div>
                                <div class="col-4">
                                    <div class="row align-items-center">
                                        <div class="input-group rounded-5">
                                            <input type="text" id="search" placeholder="Search ..."
                                                class="form-control rounded-4 border position-relative" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mt-3 search-table" id="Table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Gender</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>

                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        @foreach ($customers as $customer)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $customer->first_name }}</td>
                                                <td>{{ $customer->last_name }}</td>
                                                <td>{{ $customer->gender }}</td>
                                                <td>{{ $customer->email }}</td>
                                                <td>{{ $customer->phone }}</td>
                                                <td>{{ $customer->address }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-Start mb-3">
                                    <button id="prevBtn" class="btn border btn-sm me-2 rounded-5 border-dark txt-dark"
                                        onclick="prevPage()" disabled><i class="fa-solid fa-angle-left"></i>
                                        Previous</button>
                                    <button id="nextBtn" class="btn border btn-sm rounded-5 border-dark txt-dark"
                                        onclick="nextPage()">Next <i class="fa-solid fa-angle-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif (Auth::user()->role === 'staff')
                <div class="col-12 col-md-12">
                    <div class="card mt-3 mx-2">
                        <div class="card-body">
                            <div class="row m-2 align-items-center">
                                <div class="col-8 p-0">
                                    <h3 class="m-3">Staffs Data</h3>
                                </div>
                                <div class="col-4">
                                    <div class="row align-items-center">
                                        <div class="input-group rounded-5">
                                            <input type="text" id="search" placeholder="Search ..."
                                                class="form-control rounded-4 border position-relative" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mt-3 search-table" id="Table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Staff Name</th>
                                            <th>Position</th>
                                            <th>Department</th>
                                            <th>Salary</th>
                                            <th>Date Hired</th>
                                            <th>Status</th>

                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        @foreach ($staffs as $staff)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $staff->user->name }}</td>
                                                <td>{{ $staff->position }}</td>
                                                <td>{{ $staff->department }}</td>
                                                <td>{{ $staff->salary }}</td>
                                                <td>{{ $staff->date_hired }}</td>
                                                <td>
                                                    @if (strtolower($staff->status) === 'active')
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-Start mb-3 ">
                                <button id="prevBtn" class="btn border btn-sm me-2 rounded-5 border-dark txt-dark"
                                    onclick="prevPage()" disabled><i class="fa-solid fa-angle-left"></i> Previous</button>
                                <button id="nextBtn" class="btn border btn-sm rounded-5 border-dark txt-dark"
                                    onclick="nextPage()">Next <i class="fa-solid fa-angle-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>



    </div>
@endsection
