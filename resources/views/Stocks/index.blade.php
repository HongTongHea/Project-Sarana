@extends('layouts.app')

@section('title', ' Clothes Store | Stocks Data')

@section('content')
    <div class="m-4 mt-4">
        <div class="card rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="mt-3 ms-1 text-black text-uppercase text-start" style="font-weight: 700; font-size: 25px">
                        Stocks Quantity List
                    </h6>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="DataTable" class="table mt-3 table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Stocks</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach ($stocks as $stock)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>

                                    <td>
                                        @if ($stock->product->picture_url)
                                            <img src="{{ asset('storage/' . $stock->product->picture_url) }}"
                                                alt="{{ $stock->product->name }}" width="70" height="70"
                                                style="object-fit: cover; object-position: center;">
                                        @else
                                            <img src="{{ asset('assets/img/image.png') }}" width="70" height="70"
                                                style="object-fit: cover;">
                                        @endif
                                    </td>
                                    <td>{{ $stock->product->name }}</td>
                                    <td class="{{ $stock->quantity > 0 ? 'text-success fw-bold' : 'text-danger fw-bold' }}">
                                        {!! $stock->quantity > 0
                                            ? '<i class="fas fa-check-circle me-1"></i>' . $stock->quantity
                                            : '<i class="fas fa-times-circle me-1"></i>Out of stock' !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
