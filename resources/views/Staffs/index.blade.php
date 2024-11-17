@extends('layouts.app')

@section('title', 'Customers Data')

@section('content')
    <div class="container mt-2" data-aos="fade-down" data-aos-duration="1000">
        <h3 class="m-3">Staffs Data</h3>
        <div class="card">
            <div class="card-body">

                <div class="row m-2 align-items-center">
                    <div class="col-8 p-0">

                        <a href="{{ route('staffs.create') }}" class="btn btn-primary mb-3 btn-sm rounded-5"><i
                                class="fa-solid fa-circle-plus"></i> New
                            Staff</a>
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
                                        <div class="dropdown">
                                            <button class="btn btn-warning rounded-5 dropdown-toggle btn-sm" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu">

                                                <li><a class="dropdown-item"
                                                        href="{{ route('staffs.edit', $staff->id) }}">Edit</a></li>
                                                <li>
                                                    <form action="{{ route('staffs.destroy', $staff->id) }}" method="POST">
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
