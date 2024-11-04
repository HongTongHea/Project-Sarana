@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container mt-3 ">

        @if (Auth::user()->role === 'admin')
            <h5>Admin Dashboard</h5>
        @elseif(Auth::user()->role === 'customer')
            <h5>Customer Dashboard</h5>
        @else
            <h5>Staff Dashboard</h5>
        @endif
        <div class="card rounded-0 mt-4">
            <div class="card-body">
                <div class="row m-2 align-items-center">
                    <div class="col-8 p-0">
                        <h1>User Data</h1>
                    </div>
                    <div class="col-4">
                        <div class="row align-items-center">
                            <nav
                                class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                                <div class="input-group rounded-5">
                                    <div class="input-group-prepend">
                                        <button type="submit" class="btn btn-search pe-1">
                                            <i class="fa fa-search search-icon"></i>
                                        </button>
                                    </div>
                                    <input type="text" id="search" placeholder="Search ..." class="form-control" />
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-hover mt-3 w-100" id="Table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Profile</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
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
                                    <td>{{ $user->email }}</td>
                                    <td>{{ ucfirst($user->role) }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-warning btn-sm dropdown-toggle rounded-5" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('users.show', $user->id) }}"
                                                        class="dropdown-item">User Detail</a></li>
                                                <li><a href="{{ route('users.index', ['edit' => $user->id]) }}"
                                                        class="dropdown-item">Edit</a></li>
                                                <li>
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                        style="display:inline;">
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
                </div>

                <!-- Pagination buttons -->
                <div class="d-flex justify-content-Start ">
                    <button id="prevBtn" class="btn border btn-sm me-2 rounded-5 border-dark txt-dark"
                        onclick="prevPage()" disabled><i class="fa-solid fa-angle-left"></i> Previous</button>
                    <button id="nextBtn" class="btn border btn-sm rounded-5 border-dark txt-dark"
                        onclick="nextPage()">Next <i class="fa-solid fa-angle-right"></i></button>
                </div>

            </div>
        </div>
    </div>
@endsection
