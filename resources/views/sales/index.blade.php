{{-- @extends('layouts.app')

@section('title', 'Sales Data')

@section('content')
    <div class="m-4 mt-4">
        <h3 class="m-3">Sales Data</h3>
        <div class="card">
            <div class="card-body">
                <div class="row m-2 align-items-center">
                    <div class="col-8 p-0">

                        <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm rounded-5"><i
                                class="fa-solid fa-circle-plus"></i> New Sale</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-hover mt-3 search-table">
                        <thead class="table-warning">
                            <tr>
                                <th>Order ID</th>
                                <th>Product Name</th>
                                <th>Customer Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total Price</th>
                                <th>Sale Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $sale->order_id }} - {{ $sale->order->created_at }}</td>
                                    <td>{{ $sale->product->name }}</td>
                                    <td>{{ $sale->customer->first_name . ' ' . $sale->customer->last_name }}</td>
                                    <td>{{ $sale->quantity }}</td>
                                    <td>${{ $sale->price }}</td>
                                    <td>{{ $sale->total_price }}</td>
                                    <td>{{ $sale->sale_date }}</td>
                                    <td>
                                        <div class="dropdown align-items-center d-flex">
                                            <button class="btn btn-warning rounded-5 btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false"> Action
                                            </button>
                                            <ul class="dropdown-menu">
                                                @if (Auth::user()->role === 'admin')
                                                    <li>
                                                        <a href="{{ route('sales.show', $sale->id) }}"
                                                            class="dropdown-item">View Sales</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('sales.edit', $sale->id) }}"
                                                            class="dropdown-item">Edit</a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('sales.destroy', $sale->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item"
                                                                onclick="return confirm('Are you sure?')">Delete</button>
                                                        </form>
                                                    </li>
                                                @elseif (Auth::user()->role === 'staff')
                                                    <li>
                                                        <a href="{{ route('sales.show', $sale->id) }}"
                                                            class="dropdown-item">View Sales</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('sales.edit', $sale->id) }}"
                                                            class="dropdown-item">Edit</a>
                                                    </li>
                                                @endif

                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection --}}
@extends('layouts.app')

@section('title', 'Clothes Store | Sales Data')

@section('content')
    <div class="m-4 mt-4">
        <div class="card rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/logostore2.png') }}" alt="" class="navbar-brand mr-1" height="40">
                    <h6 class="text-uppercase mt-4 ms-1 text-primary    " style="font-weight: 700; font-size: 20px">Clothes
                        <span class="text-warning">Store </span> | <span class="text-dark">Sales Data</span>

                    </h6>
                </div>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3 ml-3 rounded-3 btn-sm" data-bs-toggle="modal"
                    data-bs-target="#createModal">
                    <i class="fa-solid fa-circle-plus"></i> Add New
                </button>
                {{-- <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm rounded-5"><i
                                class="fa-solid fa-circle-plus"></i> New Sale</a> --}}
                <div class="table-responsive">
                    <table id="DataTable" class="table mt-3 table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Order ID</th>
                                <th>Product Name</th>
                                <th>Customer Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total Price</th>
                                <th>Sale Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $sale->order_id }} - {{ $sale->order->created_at }}</td>
                                    <td>{{ $sale->product->name }}</td>
                                    <td>{{ $sale->customer->first_name . ' ' . $sale->customer->last_name }}</td>
                                    <td>{{ $sale->quantity }}</td>
                                    <td>${{ $sale->price }}</td>
                                    <td>{{ $sale->total_price }}</td>
                                    <td>{{ $sale->sale_date }}</td>
                                    <td>
                                        <div class="dropdown align-items-center d-flex">
                                            <button class="btn btn-warning rounded-5 btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false"> Action
                                            </button>
                                            <ul class="dropdown-menu">
                                                @if (Auth::user()->role === 'admin')
                                                    <li>
                                                        <a href="{{ route('sales.show', $sale->id) }}"
                                                            class="dropdown-item">View Sales</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('sales.edit', $sale->id) }}"
                                                            class="dropdown-item">Edit</a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('sales.destroy', $sale->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item"
                                                                onclick="return confirm('Are you sure?')">Delete</button>
                                                        </form>
                                                    </li>
                                                @elseif (Auth::user()->role === 'staff')
                                                    <li>
                                                        <a href="{{ route('sales.show', $sale->id) }}"
                                                            class="dropdown-item">View Sales</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('sales.edit', $sale->id) }}"
                                                            class="dropdown-item">Edit</a>
                                                    </li>
                                                @endif

                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('customers.create') --}}
@endsection
