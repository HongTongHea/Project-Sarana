@extends('layouts.app')

@section('title', 'Clothes Store | Categories Data')

@section('content')

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/logostore2.png') }}" alt="" class="navbar-brand mr-1" height="40">
                    <h6 class="text-uppercase mt-4 ms-1 text-primary    " style="font-weight: 700; font-size: 20px">Clothes
                        <span class="text-warning">Store </span> | <span class="text-dark">Categories Data</span>

                    </h6>
                </div>
            </div>
            <div class="card-body">
                <button class="btn btn-primary btn-sm mb-3 ml-3 rounded-3" data-toggle="modal" data-target="#createModal">
                    <i class="fa-solid fa-circle-plus"></i> Add New
                </button>
                <div class="table-responsive">
                    <table id="DataTable" class="table mt-3 table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#showModal{{ $category->id }}"><i
                                                class="fa-solid fa-circle-info"></i></button>

                                        <button class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#editModal{{ $category->id }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#deleteModal{{ $category->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Edit Category Modal -->
                                @include('categories.show')
                                @include('categories.edit')
                                <!-- Delete Category Modal -->
                                @include('categories.delete')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Create Category Modal -->
    @include('categories.create')

@endsection
