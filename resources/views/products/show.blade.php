@extends('layouts.app')

@section('title', 'Product Details')

@section('content') 

    <div class="card rounded-0">
        <div class="card-body">
            <h3>Product Details</h3>
            <div class="row align-items-center">
                <div class="col-12 col-md-6">
                    @if ($product->picture_url)
                        <div class="form-group">
                            <p><strong>Product Image:</strong></p>
                            <img src="{{ Storage::url($product->picture_url) }}" alt="Product Image" class="img-thumbnail"
                                width="70%">
                        </div>
                    @endif

                </div>
                <div class="col-12 col-md-6">
                    <h1 class="mb-3">Name: {{ $product->name }}</h1>
                    <h1 class="mb-3"><strong>Size:</strong> {{ $product->size }}</h1>
                    <h1 class="mb-3"><strong>Price:</strong> ${{ $product->price }}</h1>
                    <h1 class="mb-3"><strong>Category:</strong> {{ $product->category->name }}</h1>
                    <h1 class="mb-3"><strong>Stock Quantity:</strong> {{ $product->stock_quantity }}</h1>
                    <h1 class="mb-3"><strong>Description:</strong> {{ $product->description }}</h1>
                </div>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm float-end m-1 rounded-5">Back</a>
        </div>
    </div>

@endsection
