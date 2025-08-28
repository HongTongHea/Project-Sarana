@extends('layouts.app')

@section('title', 'Angkor Tech Computer | Suppliers List')

@section('content')

    <div class="container-fluid mt-3">
        <div class="card shadow rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-semibold text-uppercase">Suppliers</h4>
                </div>
            </div>
            <div class="card-body">
                <button class="btn btn-primary btn-sm mb-3 ml-3" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="fas fa-plus"></i> New Supplier
                </button>
                <div class="table-responsive">
                    <table id="DataTable" class="table mt-3 table-border table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Supplier Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Contact Person</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $supplier)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ $supplier->email ?? 'N/A' }}</td>
                                    <td>{{ $supplier->phone ?? 'N/A' }}</td>
                                    <td>{{ $supplier->address ?? 'N/A' }}</td>
                                    <td>{{ $supplier->contact_person ?? 'N/A' }}</td>
                                    <td class="text-nowrap text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton{{ $supplier->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false" title="Actions">
                                                <i class="fas fa-ellipsis-v fs-6"></i>
                                            </button>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $supplier->id }}">
                                                <!-- Edit -->
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $supplier->id }}">
                                                        <i class="fa-solid fa-pen-to-square me-2 text-warning"></i>
                                                        Edit
                                                    </button>
                                                </li>

                                                <!-- Delete -->
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $supplier->id }}">
                                                        <i class="fa-solid fa-trash me-2 text-danger"></i>
                                                        Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                {{-- <!-- View Supplier Modal -->
                                @include('suppliers.show') --}}
                                <!-- Edit Supplier Modal -->
                                @include('suppliers.edit')
                                <!-- Delete Supplier Modal -->
                                @include('suppliers.delete')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Create Supplier Modal -->
    @include('suppliers.create')

@endsection
