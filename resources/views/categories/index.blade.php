@extends('layouts.app')
@section('title', 'Categories Data')
@section('content')
   
    <div class="container" data-aos="fade-down" data-aos-duration="1000">
        <h3 class="m-3">{{ isset($category) ? 'Update Category' : 'Create New Category' }}</h3>
        <div class="container p-2">
            <div class="card">
                <div class="card-body">

                    <form
                        action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @if (isset($category))
                            @method('PUT')
                        @endif
                        <div class="row m-1 align-item-center border rounded-2">
                            <div class="form-group col-12 col-md-6 p-2">
                                <div class="row">
                                    <div class="form-group col-12 col-md-10 mb-3 ps-4">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ old('name', isset($category) ? $category->name : '') }}" required>
                                    </div>
                                    <div class="form-group col-12 col-md-10  ps-4">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control" rows="7" required>{{ old('description', isset($category) ? $category->description : '') }}</textarea>
                                    </div>

                                </div>
                            </div>


                            <div class="col-12 col-md-6 mt-4">
                                <div class="swiper">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide"><img src="/assets/img/pic (1).png" alt></div>
                                        <div class="swiper-slide"><img src="/assets/img/pic (2).png" alt></div>
                                        <div class="swiper-slide"><img src="/assets/img/pic (3).png" alt></div>
                                        <div class="swiper-slide"><img src="/assets/img/pic (4).png" alt></div>
                                    </div>
                                    <div class="swiper-pagination"></div>
                                    {{-- <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div> --}}
                                </div>
                            </div>


                        </div>
                        <div class="float-end mt-1 m-1">

                            <button type="submit" class="btn btn-primary btn-sm rounded-5 ">
                                {{ isset($category) ? 'Save Changes' : 'Add Category' }}
                            </button>
                            @if (isset($category))
                                <a href="{{ route('categories.index') }}"
                                    class="btn btn-secondary btn-sm  m-1 rounded-5">Cancel</a>
                            @endif

                        </div>
                    </form>

                    <div class="row m-1 mt-5 align-items-center w-100">
                        <hr class="mt-2 ">
                        <div class="col-8 p-0">
                            <h3 class="m-3">Category Data</h3>
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
                        <table class="table table-hover search-table" id="CategoryTableData">
                            <thead class="table-warning">
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
                                            <a href="{{ route('categories.index', ['edit' => $category->id]) }}"
                                                class="btn btn-primary btn-sm rounded-5"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>

                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm rounded-5"
                                                    onclick="return confirm('Are you sure you want to delete this user?')"><i
                                                        class="fa-regular fa-trash-can"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-Start mb-3">
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

@endsection
