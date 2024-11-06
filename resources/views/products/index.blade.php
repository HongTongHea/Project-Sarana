@extends('layouts.app')
@section('title', 'Management Product')
@section('content')

<div class="container mt-5">
    <h2>Product List</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add New Product</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Size</th>
                <th>Stock Quantity</th>
                <th>Category</th>
                <th>Image URL</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->size }}</td>
                    <td>{{ $product->stock_quantity }}</td>
                    <td>{{ $product->category->name ?? 'N/A' }}</td> <!-- Display category name or N/A -->
                    <td>
                        @if ($product->picture_url)
                        <img src="{{ asset('storage/' . $product->picture_url) }}"
                            alt="{{ $product->name }}"
                            class="avatar-img avatar-lg rounded-5 object-fit-cover object-center"
                            width="100">
                    @else
                        No picture
                    @endif
                    </td>
                    <td>
                        <a href="" class="btn btn-info btn-sm">View</a>
                        <a href="" class="btn btn-warning btn-sm">Edit</a>
                        <form action="" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection