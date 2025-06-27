@extends('layouts.app')

@section('title', ' Clothes Store | Stocks Data')

@section('content')
    <div class="m-4 mt-4">
        <div class="card rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/logostore2.png') }}" alt="" class="navbar-brand" height="40">
                    <h6 class="text-uppercase mt-4 ms-1 text-primary" style="font-weight: 700; font-size: 20px">
                        Clothes
                        <span class="text-warning">Store </span> | <span class="text-dark">Stocks Data</span>

                    </h6>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="DataTable" class="table mt-3 table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Product Image</th>
                                <th>Product</th>
                                <th>Stock Quantity</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach ($stocks as $stock)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>
                                        @if ($stock->product->picture_url)
                                            <img src="{{ asset('storage/' . $stock->product->picture_url) }}"
                                                alt="{{ $stock->product->name }}"
                                                class="avatar-img avatar-lg rounded-5 object-fit-cover object-center"
                                                width="80">
                                        @else
                                            <img src="{{ asset('assets/img/image.png') }}" class=""
                                                class="avatar-img avatar-lg rounded-5 object-fit-cover object-center"
                                                width="80">
                                        @endif
                                    </td>
                                    <td>{{ $stock->product->name }}</td>
                                    <td>{{ $stock->quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
