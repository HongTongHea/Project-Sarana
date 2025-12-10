@extends('layouts.app')

@section('title', 'AngkorTech Computer | Employees')

@section('content')
    <div class="container-fluid mt-3">
        <div class="card rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-semibold text-uppercase">Employees</h4>
                </div>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3 ml-3 btn-sm" data-bs-toggle="modal"
                    data-bs-target="#createModal">
                    <i class="fas fa-plus"></i> New Employee
                </button>

                <div class="table-responsive">
                    <table id="DataTable" class="table mt-3 table-border table-hover ">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Profile</th>
                                <th>Full Name</th>
                                <th>Position</th>
                                <th>Emial</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        @if ($employee->picture_url)
                                            <img src="{{ asset('storage/' . $employee->picture_url) }}"
                                                alt="{{ $employee->name }}"
                                                class="avatar-img avatar-lg rounded-5 object-fit-cover object-center"
                                                width="80">
                                        @else
                                            <div class="avatar-img rounded-5 d-flex align-items-center justify-content-center bg-secondary"
                                                style="width: 50px; height: 50px;color: #fff; font-size: 20px; font-weight: bold;">
                                                {{ strtoupper(substr($employee->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->position }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td> {{ $employee->phone }}</td>
                                    <td>
                                        <span class="badge {{ $employee->status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $employee->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-nowrap text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton{{ $employee->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false" title="Actions">
                                                <i class="fas fa-ellipsis-v fs-6"></i>
                                            </button>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $employee->id }}">
                                                <!-- View Details -->
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#showModal{{ $employee->id }}">
                                                        <i class="fa-solid fa-circle-info me-2 text-info"></i>
                                                        View Details
                                                    </button>
                                                </li>

                                                <!-- Edit -->
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $employee->id }}">
                                                        <i class="fa-solid fa-pen-to-square me-2 text-warning"></i>
                                                        Edit
                                                    </button>
                                                </li>

                                                <!-- Delete -->
                                                <li>
                                                    @if (Auth::user()->role === 'admin')
                                                        <button class="dropdown-item d-flex align-items-center"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $employee->id }}">
                                                            <i class="fa-solid fa-trash me-2 text-danger"></i>
                                                            Delete
                                                        </button>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Show Modal -->
                                @include('employees.show', ['employee' => $employee])
                                <!-- Edit Modal -->
                                @include('employees.edit', ['employee' => $employee])
                                <!-- Delete Modal -->
                                @include('employees.delete', ['employee' => $employee])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('employees.create')
@endsection
