<!-- resources/views/products/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Product</h2>
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" class="form-control" id="price" name="price" value="{{ $product->price }}">
        </div>

        <div class="form-group">
            <label for="size">Size</label>
            <select class="form-control" id="size" name="size">
                @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
                    <option value="{{ $size }}" {{ $product->size == $size ? 'selected' : '' }}>{{ $size }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="stock_quantity">Stock Quantity</label>
            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="{{ $product->stock_quantity }}">
        </div>

        <div class="form-group">
            <label for="picture_url">Image URL</label>
            <input type="text" class="form-control" id="picture_url" name="picture_url" value="{{ $product->image_url }}">
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
    </form>
</div>
@endsection
