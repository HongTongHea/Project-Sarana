@extends('layouts.app')

@section('title', 'Customers Data')

@section('content')
    <div class="container mt-2" data-aos="fade-down" data-aos-duration="1000">
        <h3 class="m-3">Customer Data</h3>
        <div class="card">
            <div class="card-body">

                <div class="row m-2 align-items-center">
                    <div class="col-8 p-0">

                        <a href="{{ route('customers.create') }}" class="btn btn-primary mb-3 btn-sm rounded-5"><i
                                class="fa-solid fa-circle-plus"></i> New
                            Customer</a>
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
                    <table class="table table-sm table-hover mt-3 search-table" id="Table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>F-Name</th>
                                <th>L-Name</th>
                                <th>Gender</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $customer->first_name }}</td>
                                    <td>{{ $customer->last_name }}</td>
                                    <td>{{ $customer->gender }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-warning rounded-5 dropdown-toggle btn-sm" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu">
                                                @if (Auth::user()->role === 'admin')
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('customers.show', $customer->id) }}">Veiw
                                                            Detail</a>
                                                    </li>
                                                    <li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('customers.edit', $customer->id) }}">Edit</a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('customers.destroy', $customer->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item">Delete</button>
                                                        </form>
                                                    </li>
                                                @elseif (Auth::user()->role === 'staff')
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('customers.show', $customer->id) }}">Veiw
                                                            Detail</a>
                                                    </li>
                                                    <li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('customers.edit', $customer->id) }}">Edit</a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-Start mb-3 ">
                    <button id="prevBtn" class="btn border btn-sm me-2 rounded-5 border-dark txt-dark"
                        onclick="prevPage()" disabled><i class="fa-solid fa-angle-left"></i> Previous</button>
                    <button id="nextBtn" class="btn border btn-sm rounded-5 border-dark txt-dark"
                        onclick="nextPage()">Next <i class="fa-solid fa-angle-right"></i></button>
                </div>
            </div>
        </div>
    </div>

@endsection
