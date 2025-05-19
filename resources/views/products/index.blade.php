@extends('layouts.app')
@section('title', ' Clothes Store | Products Data')
@section('content')

    <div class="m-4 mt-4">
        <div class="card rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/logostore2.png') }}" alt="" class="navbar-brand mr-1" height="40">
                    <h6 class="text-uppercase mt-4 ms-1 text-primary    " style="font-weight: 700; font-size: 20px">Clothes
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
                            <div class="card  rounded-0">
                                <div class="card-body p-2">
                                    <div class="text-center">
                                        @if ($product->picture_url)
                                            <img src="{{ asset('storage/' . $product->picture_url) }}"
                                                alt="{{ $product->name }}" class="w-100 d-block mx-auto"
                                                style="height: 200px; object-fit: cover; object-position: center;">
                                        @else
                                            <img src="{{ asset('assets/img/image.png') }}" class=""
                                                style="height: 200px; object-fit: cover; object-position: center;">
                                        @endif
                                    </div>
                                    <p class="card-text">
                                    <h3 class="text-center"><strong>{{ $product->name }}</strong> </h3><br>
                                    <strong>Description:</strong> {{ $product->description ?? 'N/A' }}<br>
                                    <strong>Price:</strong> ${{ number_format($product->price, 2) }}<br>
                                    <strong>Sizes:</strong>
                                    @if ($product->sizes && $product->sizes->count())
                                        {{ $product->sizes->pluck('size')->implode(', ') }}
                                    @else
                                        No size
                                    @endif
                                    <br>

                                    <strong>Stock:</strong> {{ $product->stock_quantity }}<br>
                                    <strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}
                                    </p>
                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <button type="button" class="btn btn-info btn-sm me-2" data-bs-toggle="modal"
                                        data-bs-target="#showModal{{ $product->id }}"><i
                                            class="fa-solid fa-circle-info"></i></button>

                                    <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $product->id }}"> <i
                                            class="fa-solid fa-pen-to-square"></i></button>

                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $product->id }}"><i
                                            class="fa-solid fa-trash"></i></button>

                                </div>
                            </div>
                        </div>
                        @include('products.show', ['product' => $product])
                        @include('products.edit', ['product' => $product])
                        @include('products.delete', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('products.create')
@endsection
