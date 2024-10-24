@extends('layouts.app')

@section('title', 'Customers')

@section('content')
    <div class="card rounded-0">
        <div class="card-body">
            <h2>Customers</h2>
            <div class="row m-1 align-items-center">
                <div class="col-8 p-0">
                    <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm">Create New Customer</a>
                </div>

                <div class="col-4">
                    <div class="row align-items-center">
                        <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
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
            <table class="table table-responsive table-sm table-hover mt-3" id="Table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>First Name</th>
                        <th>Last Name</th>
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
                            <td>{{ $customer->first_name }}</td>
                            <td>{{ $customer->last_name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->address }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Action
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item"
                                                href="{{ route('customers.show', $customer->id) }}">Veiw    Detail</a></li>
                                        <li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('customers.edit', $customer->id) }}">Edit</a></li>
                                        <li>
                                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item">Delete</button>
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
    </div>
@endsection
