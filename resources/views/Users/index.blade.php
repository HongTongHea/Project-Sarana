@extends('layouts.app')

@section('title', 'Clothes Store | Users Information')

@section('content')
    <div class="m-3 mt-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/logostore2.png') }}" alt="" class="navbar-brand mr-1" height="40">
                    <h6 class="text-uppercase mt-4 ms-1 text-primary    " style="font-weight: 700; font-size: 20px">
                        Clothes
                        <span class="text-warning">Store </span> | <span class="text-dark">Users Information</span>
                    </h6>
                </div>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3 ml-3 rounded-3 btn-sm" data-bs-toggle="modal"
                    data-bs-target="#createModal">
                    <i class="fa-solid fa-circle-plus"></i> Add New
                </button>

                <div class="table-responsive">
                    <table id="DataTable" class="table mt-3 table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        @if ($user->picture_url)
                                            <img src="{{ asset('storage/' . $user->picture_url) }}"
                                                alt="{{ $user->name }}"
                                                class="avatar-img avatar-lg rounded-5 object-fit-cover object-center"
                                                width="80">
                                        @else
                                            <img src="{{ asset('assets/img/Default_pfp.svg.png') }}"
                                                alt="{{ $user->name }}"
                                                class="avatar-img avatar-lg rounded-5 object-fit-cover object-center"
                                                width="80">
                                        @endif
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <!-- Show Button -->
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#showModal{{ $user->id }}"><i
                                                class="fa-solid fa-circle-info"></i></button>

                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $user->id }}"> <i
                                                class="fa-solid fa-pen-to-square"></i></button>

                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $user->id }}"><i
                                                class="fa-solid fa-trash"></i></button>

                                    </td>
                                </tr>

                                <!-- Show Modal -->
                                @include('users.detail', ['user' => $user])
                                <!-- Edit Modal -->
                                @include('users.edit', ['user' => $user])
                                <!-- Delete Modal -->
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
