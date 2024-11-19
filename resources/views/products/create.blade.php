@extends('layouts.app')

@section('title', 'Add New Product')

@section('content')
    <div class="container mt-3" data-aos="fade-down" data-aos-duration="1000">
        <h3 class="m-3">Add New Product</h3>
        <div class="card">
            <div class="card-body">
                {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" name="name" class="form-control" id="name"
                                value="{{ old('name') }}" required>
                        </div>


                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" step="0.01" name="price" class="form-control" id="price"
                                value="{{ old('price') }}" required>
                        </div>

                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="size" class="form-label">Size</label>
                            <select name="size" class="form-select form-control" id="size" required>
                                <option value="">Select Size</option>
                                <option value="XS" {{ old('size') == 'XS' ? 'selected' : '' }}>XS</option>
                                <option value="S" {{ old('size') == 'S' ? 'selected' : '' }}>S</option>
                                <option value="M" {{ old('size') == 'M' ? 'selected' : '' }}>M</option>
                                <option value="L" {{ old('size') == 'L' ? 'selected' : '' }}>L</option>
                                <option value="XL" {{ old('size') == 'XL' ? 'selected' : '' }}>XL</option>
                                <option value="XXL" {{ old('size') == 'XXL' ? 'selected' : '' }}>XXL</option>
                            </select>
                        </div>


                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" class="form-select form-control" id="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="stock_quantity" class="form-label">Stock Quantity</label>
                            <input type="number" name="stock_quantity" class="form-control" id="stock_quantity">
                 
                        </div>

                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="picture_url">Product Image:
                                @if ($errors->has('picture_url'))
                                    <label class="text-danger mt-1">{{ $errors->first('picture_url') }}</label>
                                @endif
                            </label>

                            <input type="file" class="form-control" name="picture_url" id="picture_url" accept="image/*">

                        </div>

                        <div class="form-group mb-2">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description" rows="4">{{ old('description') }}</textarea>
                        </div>

                    </div>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm rounded-5 mb-3 float-end">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm rounded-5 mb-3 float-end me-1">Add Product</button>
                </form>
            </div>
        </div>

    </div>
  


@endsection
