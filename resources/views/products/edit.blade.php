@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container mt-2">
    <h1>Edit Product</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required>{{ $product->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
        </div>

        <div class="form-group">
            <label for="size">Size</label>
            <select name="size" class="form-control" required>
                <option value="XS" {{ $product->size == 'XS' ? 'selected' : '' }}>XS</option>
                <option value="S" {{ $product->size == 'S' ? 'selected' : '' }}>S</option>
                <option value="M" {{ $product->size == 'M' ? 'selected' : '' }}>M</option>
                <option value="L" {{ $product->size == 'L' ? 'selected' : '' }}>L</option>
                <option value="XL" {{ $product->size == 'XL' ? 'selected' : '' }}>XL</option>
                <option value="XXL" {{ $product->size == 'XXL' ? 'selected' : '' }}>XXL</option>
            </select>
        </div>

        <div class="form-group">
            <label for="stock_quantity">Stock Quantity</label>
            <input type="number" name="stock_quantity" class="form-control" value="{{ $product->stock_quantity }}" required>
        </div>

        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" class="form-control" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="file">Upload File</label>
            <input type="file" class="form-control" id="file" name="file">
        </div>

        @if ($product->picture_url)
            <div class="form-group">
                <p>Current File:</p>
                <img src="{{ Storage::url($product->picture_url) }}" alt="Product Image" class="img-thumbnail" width="150">
            </div>
        @endif

        <button type="submit" class="btn btn-primary btn-sm rounded-5">Update Product</button>
    </form>
</div>
@endsection
