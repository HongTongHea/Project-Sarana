@extends('layouts.app')

@section('title', 'Angkor Tech Computer | Users ')

@section('content')
    <div class="m-3 mt-4">

        <!-- Users Table -->
        <div class="card rounded-0 mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-semibold text-uppercase">Users Management</h4>

            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary btn-sm mb-3 ml-3" data-bs-toggle="modal"
                    data-bs-target="#createModal">
                    <i class="fas fa-plus"></i> New User
                </button>
                <div class="table-responsive">
                    <table id="DataTable" class="table table-border table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Profile</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($user->picture_url)
                                            <img src="{{ asset('storage/' . $user->picture_url) }}"
                                                alt="{{ $user->name }}"
                                                class="avatar-img avatar-lg rounded-5 object-fit-cover object-center"
                                                width="80">
                                        @else
                                            <div class="avatar-img rounded-5 d-flex align-items-center justify-content-center bg-secondary"
                                                style="width: 50px; height: 50px;color: #fff; font-size: 20px; font-weight: bold;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span
                                            class="badge 
                                            @if ($user->role == 'admin') bg-danger
                                            @elseif($user->role == 'author') bg-warning
                                            @else bg-primary @endif">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">Active</span>
                                    </td>
                                    <td class="text-nowrap text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton{{ $user->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fs-6"></i>
                                            </button>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $user->id }}">
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $user->id }}">
                                                        <i class="fa-solid fa-pen-to-square me-2 text-warning"></i> Edit
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $user->id }}">
                                                        <i class="fa-solid fa-trash me-2 text-danger"></i> Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                @include('users.edit', ['user' => $user])
                                @include('users.delete', ['user' => $user])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    @include('users.create')
@endsection
