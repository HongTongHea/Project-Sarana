@extends('layouts.app')
@section('title', 'AngkorTech Computer | Products List')
@section('content')
    <div class="m-4 mt-4">
        <div class="card shadow rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="mt-3 ms-1 text-black text-uppercase text-start" style="font-weight: 700; font-size: 25px">
                        Products List
                    </h6>
                </div>
            </div>
            <div class="card-body">
                <button class="btn btn-primary btn-sm mb-3 ml-3 rounded-3" data-bs-toggle="modal"
                    data-bs-target="#createModal">
                    <i class="fa-solid fa-circle-plus"></i> Add New
                </button>
                <div class="table-responsive">
                    <table id="DataTable" class="table mt-3 table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th width="11%">Stock</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Brand</th>
                                <th>Barcode</th>
                                <th>Discount</th>
                                <th>Price</th>
                          
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td
                                        class="{{ $product->stock_quantity > 0 ? 'text-warning fw-bold' : 'text-danger fw-bold' }}">
                                        {!! $product->stock_quantity > 0
                                            ? '<i class="fas fa-check-circle me-1"></i>' . $product->stock_quantity
                                            : '<i class="fas fa-times-circle me-1"></i>Out stock' !!}
                                    </td>
                                    <td>
                                        @if ($product->picture_url)
                                            <img src="{{ asset('storage/' . $product->picture_url) }}"
                                                alt="{{ $product->name }}" width="70" height="70"
                                                style="object-fit: cover; object-position: center;">
                                        @else
                                            <img src="{{ asset('assets/img/image.png') }}" width="70" height="70"
                                                style="object-fit: cover;">
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->brand }}</td>
                                    <td>{{ $product->barcode }}</td>
                                    <td>{{ $product->discount_percentage ? $product->discount_percentage . '%' : 'None' }}
                                    </td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                    <td class="text-nowrap text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton{{ $product->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false" title="Actions">
                                                <i class="fas fa-ellipsis-v fs-6"></i>
                                            </button>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $product->id }}">
                                                <!-- View Details -->
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#showModal{{ $product->id }}">
                                                        <i class="fa-solid fa-circle-info me-2 text-info"></i>
                                                        View Details
                                                    </button>
                                                </li>

                                                <!-- Edit -->
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $product->id }}">
                                                        <i class="fa-solid fa-pen-to-square me-2 text-warning"></i>
                                                        Edit
                                                    </button>
                                                </li>

                                                <!-- Delete -->
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $product->id }}">
                                                        <i class="fa-solid fa-trash me-2 text-danger"></i>
                                                        Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @include('products.show', ['product' => $product])
                                @include('products.edit', ['product' => $product])
                                @include('products.delete', ['product' => $product])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('products.create')
@endsection
