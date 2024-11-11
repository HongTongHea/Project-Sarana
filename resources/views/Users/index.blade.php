@extends('layouts.app')
@section('title', 'Users Data')
@section('content')
    <div class="container">
        <div class="row">
            <div class="container p-4 pt-0">
                <h3 class="m-3">{{ isset($user) ? 'Update User' : 'Create New User' }}</h3>
                <div class="card">
                    <div class="card-body ">


                        <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($user))
                                @method('PUT')
                            @endif
                            @if (isset($user) && $user->picture_url)
                                <img src="{{ Storage::url($user->picture_url) }}" alt="Profile Picture"
                                    class="avatar-img avatar-lg rounded-5 object-fit-cover object-center m-3 mt-0 mb-2"
                                    width="100%">
                            @endif
                            <div class="row m-1 align-items-center border rounded-3 border-info">
                                <div class="form-group col-12 col-md-6 ps-2">

                                    <div class="row">
                                        <div class="form-group  col-12 col-md-6 ps-4">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                value="{{ old('name', isset($user) ? $user->name : '') }}" required>
                                        </div>

                                        <div class="form-group col-12 col-md-6 ps-4">
                                            <label for="email">Email
                                                @if ($errors->has('email'))
                                                    <label class="text-danger mt-1">{{ $errors->first('email') }}</label>
                                                @endif
                                            </label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                value="{{ old('email', isset($user) ? $user->email : '') }}" required>
                                        </div>

                                        <div class="form-group col-12 col-md-6 ps-4">
                                            <label for="password">Password
                                                @if ($errors->has('password'))
                                                    <label class="text-danger mt-1">{{ $errors->first('password') }}</label>
                                                @endif
                                            </label>
                                            <input type="password" name="password" id="password" class="form-control"
                                                {{ isset($user) ? '' : 'required' }}>

                                        </div>

                                        <div class="form-group col-12 col-md-6 ps-4">
                                            <label for="password_confirmation">Confirm Password
                                                @if ($errors->has('password_confirmation'))
                                                    <label
                                                        class="text-danger mt-1">{{ $errors->first('password_confirmation') }}
                                                    </label>
                                                @endif
                                            </label>
                                            <input type="password" name="password_confirmation" id="password_confirmation"
                                                class="form-control" {{ isset($user) ? '' : 'required' }}>

                                        </div>


                                        <div class="form-group col-12 col-md-6 ps-4">
                                            <label for="role">Role</label>
                                            <select name="role" id="role" class="form-control" required>
                                                <option value="">Select Role</option>
                                                <option value="admin"
                                                    {{ old('role', isset($user) && $user->role == 'admin' ? 'selected' : '') }}>
                                                    Admin</option>
                                                <option value="customer"
                                                    {{ old('role', isset($user) && $user->role == 'customer' ? 'selected' : '') }}>
                                                    Customer</option>
                                                <option value="staff"
                                                    {{ old('role', isset($user) && $user->role == 'staff' ? 'selected' : '') }}>
                                                    Staff</option>
                                            </select>
                                        </div>


                                        <div class="form-group col-12 col-md-6 ps-4">
                                            <label for="picture_url">Profile Picture</label>
                                            <input type="file" name="picture_url" class="form-control">
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6 ps-4">
                                    <img src="/assets/img/user data.png" alt="" width="100%">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm float-end m-1 rounded-5">
                                {{ isset($user) ? 'Update' : 'Save' }}
                            </button>
                            @if (isset($user))
                                <a href="{{ route('users.index') }}"
                                    class="btn btn-secondary btn-sm float-end m-1 rounded-5">Cancel</a>
                            @endif
                        </form>

                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row m-2 align-items-center">
                            <div class="col-8 p-0">
                                <h2 class="m-3">User Data</h2>
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
                                        <th>No</th>
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
                                                                class="dropdown-item">Update</a></li>
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
                            <div class="d-flex justify-content-Start ">
                                <button id="prevBtn" class="btn border btn-sm me-2 rounded-5 border-dark txt-dark"
                                    onclick="prevPage()" disabled><i class="fa-solid fa-angle-left"></i> Previous</button>
                                <button id="nextBtn" class="btn border btn-sm rounded-5 border-dark txt-dark"
                                    onclick="nextPage()">Next <i class="fa-solid fa-angle-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
