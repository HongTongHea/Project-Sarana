@extends('layouts.app')

@section('title', 'Update Product')

@section('content')
    <div class="container mt-3" data-aos="fade-down" data-aos-duration="1000">
        <h3 class="m-3">Upadate Product</h3>

        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        <div class="card">
            <div class="card-body">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                        </div>


                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="price">Price</label>
                            <input type="number" name="price" class="form-control" value="{{ $product->price }}"
                                required>
                        </div>

                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="size">Size</label>
                            <select name="size" class="form-control form-select" required>
                                <option value="XS" {{ $product->size == 'XS' ? 'selected' : '' }}>XS</option>
                                <option value="S" {{ $product->size == 'S' ? 'selected' : '' }}>S</option>
                                <option value="M" {{ $product->size == 'M' ? 'selected' : '' }}>M</option>
                                <option value="L" {{ $product->size == 'L' ? 'selected' : '' }}>L</option>
                                <option value="XL" {{ $product->size == 'XL' ? 'selected' : '' }}>XL</option>
                                <option value="XXL" {{ $product->size == 'XXL' ? 'selected' : '' }}>XXL</option>
                            </select>
                        </div>

                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="category_id">Category</label>
                            <select name="category_id" class="form-control form-select" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-12 col-md-6 mb-3">
                            <label for="stock_quantity">Stock Quantity</label>
                            <input type="number" name="stock_quantity" class="form-control"
                                value="{{ $product->stock_quantity }}" required min="0">
                        </div>

                        <div class="form-group col-12 col-md-6  mb-2">
                            <label for="file">Upload File
                                @if ($errors->has('file'))
                                    <label class="text-danger mt-1">{{ $errors->first('file') }}</label>
                                @endif
                            </label>
                            <input type="file" class="form-control" id="file" name="file">
                        </div>

                        <div class="form-group  mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
                        </div>

                        @if ($product->picture_url)
                            <div class="form-group col-12 col-md-6 mb-3">
                                <p>Current File:</p>
                                <img src="{{ Storage::url($product->picture_url) }}" alt="Product Image"
                                    class="img-thumbnail" width="150">
                            </div>
                        @endif
                    </div>
                    <a href="{{ route('products.index') }}"
                        class="btn btn-secondary btn-sm rounded-5 mb-3 float-end ">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm rounded-5 mb-3 float-end me-1">Update
                        Product</button>
                </form>
            </div>
        </div>
    </div>
@endsection
