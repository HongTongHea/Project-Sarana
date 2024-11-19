
@extends('layouts.app')

@section('title', 'Sales Data')

@section('content')
    <div class="container mt-2" data-aos="fade-down" data-aos-duration="1000">
        <h3 class="m-3">Sales Data</h3>
        <div class="card">
            <div class="card-body">
                <div class="row m-2 align-items-center">
                    <div class="col-8 p-0">

                        <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm rounded-5"><i
                                class="fa-solid fa-circle-plus"></i> New Sale</a>
                        

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
                    <table class="table table-sm table-hover mt-3 search-table">
                        <thead>
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
                        <tbody id="tableBody">
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
                    <div class="d-flex justify-content-Start  mb-3">
                        <button id="prevBtn" class="btn border btn-sm me-2 rounded-5 border-dark txt-dark"
                            onclick="prevPage()" disabled><i class="fa-solid fa-angle-left"></i> Previous</button>
                        <button id="nextBtn" class="btn border btn-sm rounded-5 border-dark txt-dark"
                            onclick="nextPage()">Next <i class="fa-solid fa-angle-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
