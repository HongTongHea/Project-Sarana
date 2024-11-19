@extends('layouts.app')

@section('title', 'Sales Reports')

@section('content')
    <div class="container mt-2" data-aos="fade-down" data-aos-duration="1000">
        <h3 class="m-3">Sales Reports</h3>
        <div class="card">
            <div class="card-body">
                <div class="row m-2 align-items-center">
                    <div class="col-8 p-0">
                        <a href="{{ route('sales_reports.generate') }}" class="btn btn-primary btn-sm rounded-5">Reports</a>
                       
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
                                <th>ID</th>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Total Sales</th>
                                <th>Last Updated</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @foreach ($reports as $report)
                                <tr>
                                    <td>{{ $report->id }}</td>
                                    <td>{{ $report->product->name }}</td>
                                    <td>{{ $report->customer->first_name . ' ' . $report->customer->last_name }}</td>
                                    <td>${{ number_format($report->total_sales, 2) }}</td>
                                    <td>{{ $report->updated_at->format('Y-m-d H:i') }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end  align-items-center">
                        <Strong class="txt-dark border  p-3">Total Price ${{ $sales->sum('total_price') }}</Strong>
                    </div>
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
