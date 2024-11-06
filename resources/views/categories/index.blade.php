@extends('layouts.app')
@section('title', 'Management Category')
@section('content')
    <div class="container mt-3">
        <div class="container p-2">
            <div class="card">
                <div class="card-body">

                    <div class="row d-flex justify-content-center align-item-center">
                        <div class="col-6">
                            <h1>{{ isset($category) ? 'Edit Category' : 'Create New Category' }}</h1>
                            <form
                                action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @if (isset($category))
                                    @method('PUT')
                                @endif
                                <div class="row d-flex flex-column">
                                    <div class="col-10 mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ old('name', isset($category) ? $category->name : '') }}" required>
                                    </div>
                                    <div class="col-10 mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control pb-5" required>{{ old('description', isset($category) ? $category->description : '') }}</textarea>
                                    </div>
                                    <div class="col-10">
                                        <button type="submit" class="btn btn-primary btn-sm rounded-5">
                                            {{ isset($category) ? 'Update' : 'Save' }}
                                        </button>
                                        @if (isset($category))
                                            <a href="{{ route('categories.index') }}"
                                                class="btn btn-secondary btn-sm  m-1 rounded-5">Cancel</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-6">
                            <img src="/assets/img/2663787.jpg" alt="" width="80%">
                        </div>
                    </div>
                    <hr>
                    <div class="row m-2 mt-4 align-items-center">
                        <div class="col-8 p-0">
                            <h1>Category Data</h1>
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
                    <div class="crad">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover search-table" id="CategoryTableData">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        @foreach ($categories as $index => $category)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->description }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-warning btn-sm dropdown-toggle rounded-5"
                                                            type="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">Action</button>
                                                        <ul class="dropdown-menu">

                                                            <li><a href="{{ route('categories.index', ['edit' => $category->id]) }}"
                                                                    class="dropdown-item">Edit</a></li>
                                                            <li>
                                                                <form
                                                                    action="{{ route('categories.destroy', $category->id) }}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item"
                                                                        onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-Start ">
                                    <button id="prevBtn" class="btn border btn-sm me-2 rounded-5 border-dark txt-dark"
                                        onclick="prevPage()" disabled><i class="fa-solid fa-angle-left"></i>
                                        Previous</button>
                                    <button id="nextBtn" class="btn border btn-sm rounded-5 border-dark txt-dark"
                                        onclick="nextPage()">Next <i class="fa-solid fa-angle-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
