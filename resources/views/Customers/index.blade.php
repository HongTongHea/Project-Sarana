@extends('layouts.app')

@section('title', 'Clothes Store | Customers Information')

@section('content')
    <div class="m-4 mt-4">
        <div class="card rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="mt-3 ms-1 text-black text-uppercase text-start" style="font-weight: 700; font-size: 25px">
                        Customers
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
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Gender</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $customer->first_name }}</td>
                                    <td>{{ $customer->last_name }}</td>
                                    <td>{{ $customer->gender }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>

                                        @if (Auth::user()->role === 'admin')
                                            <!-- Show Button -->
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#showModal{{ $customer->id }}"><i
                                                    class="fa-solid fa-circle-info"></i></button>

                                            <!-- Edit Button -->
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $customer->id }}"> <i
                                                    class="fa-solid fa-pen-to-square"></i></button>

                                            <!-- Delete Button -->
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $customer->id }}"><i
                                                    class="fa-solid fa-trash"></i></button>
                                        @elseif (Auth::user()->role === 'staff')
                                            <!-- Show Button -->
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#showModal{{ $customer->id }}"><i
                                                    class="fa-solid fa-circle-info"></i></button>

                                            <!-- Edit Button -->
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $customer->id }}"> <i
                                                    class="fa-solid fa-pen-to-square"></i></button>
                                        @endif
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
