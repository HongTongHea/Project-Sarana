@extends('layouts.app')

@section('title', 'AngkorTech Computer| Customers')

@section('content')
    <div class="container-fluid mt-3">
        <div class="card rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-semibold text-uppercase">Customers</h4>
                </div>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3 ml-3  btn-sm" data-bs-toggle="modal"
                    data-bs-target="#createModal">
                    <i class="fas fa-plus"></i> New Customer
                </button>

                <div class="table-responsive">
                    <table id="DataTable" class="table mt-3 table-border table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td>

                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton{{ $customer->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false" title="Actions">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $customer->id }}">
                                                <!-- View Details - Visible to both admin and staff -->
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#showModal{{ $customer->id }}">
                                                        <i class="fa-solid fa-circle-info me-2 text-info"></i>
                                                        View Details
                                                    </button>
                                                </li>

                                                <!-- Edit - Visible to both admin and staff -->
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $customer->id }}">
                                                        <i class="fa-solid fa-pen-to-square me-2 text-warning"></i>
                                                        Edit
                                                    </button>
                                                </li>

                                                @if (Auth::user()->role === 'admin')
                                                    <!-- Delete - Only visible to admin -->
                                                    <li>
                                                        <button class="dropdown-item d-flex align-items-center"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $customer->id }}">
                                                            <i class="fa-solid fa-trash me-2 text-danger"></i>
                                                            Delete
                                                        </button>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Show Modal -->
                                @include('customers.show', ['customer' => $customer])
                                <!-- Edit Modal -->
                                @include('customers.edit', ['customer' => $customer])
                                <!-- Delete Modal -->
                                @include('customers.delete', ['customer' => $customer])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('customers.create')
@endsection
