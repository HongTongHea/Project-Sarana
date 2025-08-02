@extends('layouts.app')

@section('title', 'AngkorTech Computer | Current Stock Levels')

@section('content')
    <div class="m-4 mt-4">
        <div class="card rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="mt-3 ms-1 text-black text-uppercase text-start" style="font-weight: 700; font-size: 25px">
                        Current Stock Levels
                    </h6>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="DataTable" class="table mt-3 table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                {{-- <th>No</th> --}}
                                <th>Type</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Initial Stock</th>
                                <th>Current Stock</th>
                                <th>Last Updated</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach ($currentStocks as $index => $stock)
                                <tr>
                                    {{-- <td>{{ $index + 1 }}</td> --}}
                                    <td>{{ class_basename($stock['stockable_type']) }}</td>
                                    <td>
                                        @if ($stock['stockable']->picture_url ?? false)
                                            <img src="{{ asset('storage/' . $stock['stockable']->picture_url) }}"
                                                alt="{{ $stock['stockable']->name }}" width="70" height="70"
                                                style="object-fit: cover; object-position: center;">
                                        @else
                                            <img src="{{ asset('assets/img/image.png') }}" width="70" height="70"
                                                style="object-fit: cover;">
                                        @endif
                                    </td>
                                    <td>{{ $stock['stockable']->name ?? 'N/A' }}</td>
                                    <td class="text-info fw-bold">
                                        <i class="fas fa-boxes me-1"></i>{{ $stock['initial_quantity'] }}
                                    </td>
                                    <td
                                        class="{{ $stock['current_quantity'] > 0 ? 'text-success fw-bold' : 'text-danger fw-bold' }}">
                                        <i
                                            class="fas {{ $stock['current_quantity'] > 0 ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                        {{ $stock['current_quantity'] > 0 ? $stock['current_quantity'] : 'Out of stock' }}
                                    </td>
                                    <td>{{ $stock['last_updated']->format('Y-m-d H:i') }}</td>
                                    <td>
                                        @php
                                            $difference = $stock['current_quantity'] - $stock['initial_quantity'];
                                        @endphp
                                        @if ($difference > 0)
                                            <span class="badge bg-success">
                                                <i class="fas fa-arrow-up me-1"></i>+{{ $difference }}
                                            </span>
                                        @elseif ($difference < 0)
                                            <span class="badge bg-danger">
                                                <i class="fas fa-arrow-down me-1"></i>{{ $difference }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-equals me-1"></i>No change
                                            </span>
                                        @endif
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
