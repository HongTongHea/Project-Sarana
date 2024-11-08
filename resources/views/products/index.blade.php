@extends('layouts.app')
@section('title', 'Management Product')
@section('content')

    <div class="container mt-3">
        <h1 class="m-3">Product Data</h1>
        <div class="card">
            <div class="card-body">
                <div class="row m-2 align-items-center">
                    <div class="col-8 p-0">
                       
                        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3 btn-sm rounded-5"><i class="fa-solid fa-circle-plus"></i> New
                            Product</a>
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
                    <table class="table table-hover search-table" id="ProdcutTableData">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Size</th>
                                <th>Stock Quantity</th>
                                <th>Category</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ number_format($product->price, 2) }}</td>
                                    <td>{{ $product->size }}</td>
                                    <td>{{ $product->stock_quantity }}</td>
                                    <td>{{ $product->category->name ?? 'N/A' }}</td> <!-- Display category name or N/A -->
                                    <td>
                                        @if ($product->picture_url)
                                            <img src="{{ asset('storage/' . $product->picture_url) }}"
                                                alt="{{ $product->name }}" class="object-fit-cover object-center"
                                                width="50">
                                        @else
                                            No picture
                                        @endif
                                    </td>


                                    <td>
                                        <div class="dropdown"> <button
                                                class="btn btn-warning rounded-5 btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false"> Action
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('products.show', $product->id) }}"
                                                        class="dropdown-item">Product
                                                        Detail</a></li>
                                                <li><a href="{{ route('products.edit', $product->id) }}"
                                                        class="dropdown-item">Edit</a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('products.destroy', $product->id) }}"
                                                        method="POST" style="display:inline;"> @csrf @method('DELETE')
                                                        <button type="submit" class="dropdown-item"
                                                            onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
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
                            onclick="prevPage()" disabled><i class="fa-solid fa-angle-left"></i> Previous</button>
                        <button id="nextBtn" class="btn border btn-sm rounded-5 border-dark txt-dark"
                            onclick="nextPage()">Next <i class="fa-solid fa-angle-right"></i></button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
