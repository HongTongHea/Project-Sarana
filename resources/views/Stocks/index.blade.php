@extends('layouts.app')

@section('title', ' Stocks Data')

@section('content')
    <div class="container" data-aos="fade-down" data-aos-duration="1000">
        <h3 class="m-3">{{ isset($stock) ? 'Update Stock' : 'Create New Stock' }}</h3>
        <div class="container p-2">
            <div class="card">
                <div class="card-body">

                    <!-- Create or Update Stock Form -->
                    <form action="{{ isset($stock) ? route('stocks.update', $stock->id) : route('stocks.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($stock))
                            @method('PUT')
                        @endif
                        <div class="row m-1 align-item-center border rounded-2">
                            <div class="form-group col-12 col-md-6 p-2">
                                <div class="row">
                                    <div class="form-group col-12 col-md-10 mb-3 ps-4 mt-3">
                                        <label for="product_id">Product</label>
                                        <select name="product_id" id="product_id" class="form-control form-select" required>
                                            <option value="">Select Product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}"
                                                    {{ isset($stock) && $stock->product_id == $product->id ? 'selected' : '' }}>
                                                    {{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-md-10 ps-4">
                                        <label for="stock_quantity">Stock Quantity</label>
                                        <input type="number" name="stock_quantity" id="stock_quantity" class="form-control"
                                            value="{{ old('stock_quantity', isset($stock) ? $stock->stock_quantity : '') }}"
                                            min="0" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-6 p-2">
                                <img src="/assets/img/product.png" alt="" width="80%">
                            </div>

                        </div>
                        <div class="float-end mt-1 m-1">
                            <button type="submit" class="btn btn-primary btn-sm rounded-5">
                                {{ isset($stock) ? 'Save Changes' : 'Add Stock' }}
                            </button>
                            @if (isset($stock))
                                <a href="{{ route('stocks.index') }}"
                                    class="btn btn-secondary btn-sm m-1 rounded-5">Cancel</a>
                            @endif
                        </div>
                    </form>

                    <!-- Stock List Table with Search and Actions -->
                    <div class="row m-1 mt-5 align-items-center w-100">
                        <hr class="mt-2">
                        <div class="col-8 p-0">
                            <h3 class="m-3">Stock Data</h3>
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
                        <table class="table table-hover search-table" id="StockTableData">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product</th>
                                    <th>Stock Quantity</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @foreach ($stocks as $index => $stock)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $stock->product->name }}</td>
                                        <td>{{ $stock->stock_quantity }}</td>
                                        <td>
                                            <a href="{{ route('stocks.edit', $stock->id) }}"
                                                class="btn btn-primary btn-sm rounded-5"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>

                                            <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm rounded-5"
                                                    onclick="return confirm('Are you sure you want to delete this stock?')"><i
                                                        class="fa-regular fa-trash-can"></i></button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-start mb-3">
                            <button id="prevBtn" class="btn border btn-sm me-2 rounded-5 border-dark txt-dark"
                                onclick="prevPage()" disabled><i class="fa-solid fa-angle-left"></i> Previous</button>
                            <button id="nextBtn" class="btn border btn-sm rounded-5 border-dark txt-dark"
                                onclick="nextPage()">Next <i class="fa-solid fa-angle-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
