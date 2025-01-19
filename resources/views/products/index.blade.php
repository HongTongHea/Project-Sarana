@extends('layouts.app')
@section('title', ' Clothes Store | Products Data')
@section('content')

    <div class="container mt-4">
        <div class="card rounded-2">
            <div class="card-header">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="" class="navbar-brand" height="30">
                    <h6 class="text-uppercase mt-3 ms-1 text-primary    " style="font-weight: 700; font-size: 20px">Clothes
                        <span class="text-warning">Store </span> | <span class="text-dark">Products Data</span>

                    </h6>
                </div>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary btn-sm mb-3 rounded-3" data-bs-toggle="modal"
                    data-bs-target="#createModal">
                    <i class="fa-solid fa-circle-plus"></i> Add New
                </button>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    @foreach ($products as $product)
                        <div class="col">
                            <div class="card  rounded-2">
                                <div class="card-header text-center bg-warning text-dark rounded-top-2">
                                    <h5 class="card-title mb-0">{{ $product->name }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        @if ($product->picture_url)
                                            <img src="{{ asset('storage/' . $product->picture_url) }}"
                                                alt="{{ $product->name }}" class=""
                                                style="max-width: 200px;  height: 200px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('assets/img/image.png') }}" class=""
                                                style="max-width: 200px; height: 200px; object-fit: cover;">
                                        @endif
                                    </div>
                                    <p class="card-text">
                                        <strong>Description:</strong> {{ $product->description ?? 'N/A' }}<br>
                                        <strong>Price:</strong> ${{ number_format($product->price, 2) }}<br>
                                        <strong>Size:</strong> {{ $product->size ?? 'N/A' }}<br>
                                        <strong>Stock:</strong> {{ $product->stock_quantity }}<br>
                                        <strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}
                                    </p>
                                </div>
                                <div class="card-footer d-flex justify-content-end ">
                                    <!-- Edit Button -->
                                    <button type="button" class="btn btn-warning btn-sm rounded-5 me-2"
                                        data-bs-toggle="modal" data-bs-target="#editModal{{ $product->id }}"> <i
                                            class="fa-solid fa-pen-to-square"></i></button>

                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm rounded-5 me-2"
                                            onclick="return confirm('Are you sure you want to delete this product?')">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @include('products.edit', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('products.create')
@endsection
