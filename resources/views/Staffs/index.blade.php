@extends('layouts.app')

@section('title', 'Clothes Store | Staffs imformation')

@section('content')
    <div class="container mt-4">
        <div class="card rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/logostore2.png') }}" alt="" class="navbar-brand mr-1" height="40">
                    <h6 class="text-uppercase mt-4 ms-1 text-primary    " style="font-weight: 700; font-size: 20px">Clothes
                        <span class="text-warning">Store </span> | <span class="text-dark">Staffs Information</span>

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
                                <th>Staff Name</th>
                                <th>Position</th>
                                <th>Department</th>
                                <th>Salary</th>
                                <th>Date Hired</th>
                                <th>Status</th>
                                <th>Actions</th> 
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

                                    <td>

                                        @if (Auth::user()->role === 'admin')
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#showModal{{ $staff->id }}"><i
                                                    class="fa-solid fa-circle-info"></i></button>

                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $staff->id }}"> <i
                                                    class="fa-solid fa-pen-to-square"></i></button>

                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $staff->id }}"><i
                                                    class="fa-solid fa-trash"></i></button>
                                        @elseif (Auth::user()->role === 'staff')
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#showModal{{ $staff->id }}"><i
                                                    class="fa-solid fa-circle-info"></i></button>

                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $staff->id }}"> <i
                                                    class="fa-solid fa-pen-to-square"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @include('staffs.show', ['staff' => $staff])
                            @include('staffs.edit', ['staffs' => $staff])
                            @include('staffs.delete', ['staffs' => $staff])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('staffs.create')

@endsection
