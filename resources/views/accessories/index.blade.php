@extends('layouts.app')
@section('title', 'AngkorTech Computer | Accessories List')
@section('content')
    <div class="container-fluid mt-3">
        <div class="card shadow rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-semibold text-uppercase">Accessories</h4>
                </div>
            </div>
            <div class="card-body">
                <button class="btn btn-primary btn-sm mb-3 ml-3" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="fas fa-plus"></i> New Accessories
                </button>
                <div class="table-responsive">
                    <table id="DataTable" class="table mt-3 table-border table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Stock</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Brand</th>
                                <th>Discount</th>
                                <th>Price</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accessories as $accessory)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td
                                        class="{{ $accessory->stock_quantity > 0 ? 'text-warning fw-bold' : 'text-danger fw-bold' }}">
                                        {!! $accessory->stock_quantity > 0
                                            ? '<i class="fas fa-check-circle me-1"></i>' . $accessory->stock_quantity
                                            : '<i class="fas fa-times-circle me-1"></i>Out of stock' !!}
                                    </td>
                                    <td>
                                        @if ($accessory->picture_url)
                                            <img src="{{ asset('storage/' . $accessory->picture_url) }}"
                                                alt="{{ $accessory->name }}" width="70" height="70"
                                                style="object-fit: cover; object-position: center;">
                                        @else
                                            <img src="{{ asset('assets/img/image.png') }}" width="70" height="70"
                                                style="object-fit: cover;">
                                        @endif
                                    </td>
                                    <td>{{ $accessory->name }}</td>
                                    <td>{{ $accessory->brand }}</td>
                                    <td>{{ $accessory->discount_percentage ? $accessory->discount_percentage . '%' : 'None' }}
                                    </td>
                                    <td>${{ number_format($accessory->price, 2) }}</td>
                                    <td class="text-nowrap text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton{{ $accessory->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false" title="Actions">
                                                <i class="fas fa-ellipsis-v fs-6"></i>
                                            </button>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $accessory->id }}">
                                                <!-- View Details -->
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#showModal{{ $accessory->id }}">
                                                        <i class="fa-solid fa-circle-info me-2 text-info"></i>
                                                        View Details
                                                    </button>
                                                </li>

                                                <!-- Edit -->
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $accessory->id }}">
                                                        <i class="fa-solid fa-pen-to-square me-2 text-warning"></i>
                                                        Edit
                                                    </button>
                                                </li>

                                                <!-- Delete -->
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $accessory->id }}">
                                                        <i class="fa-solid fa-trash me-2 text-danger"></i>
                                                        Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @include('accessories.show', ['accessory' => $accessory])
                                @include('accessories.edit', ['accessory' => $accessory])
                                @include('accessories.delete', ['accessory' => $accessory])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('accessories.create')
@endsection
