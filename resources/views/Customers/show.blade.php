@extends('layouts.app')

@section('title', 'Customer Details')

@section('content')

    <div class="card">
        <h2 class="m-3">Customer Details</h2>
        <div class="card-body rounded-0">
            <div class="border p-3">
                <h3>Name: {{ $customer->first_name }} {{ $customer->last_name }}</h3>
                <p><strong>Phone:</strong> {{ $customer->phone }}</p>
                <p><strong>Address:</strong> {{ $customer->address }}</p>
                <p><strong>Email:</strong> {{ $customer->email }}</p>
                <p><strong>Created At:</strong> {{ $customer->created_at->format('d-m-Y H:i') }}</p>
                <p><strong>Updated At:</strong> {{ $customer->updated_at->format('d-m-Y H:i') }}</p>
            </div>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm rounded-5 float-end mt-3">Back
            </a>
        </div>
    </div>
    </div>
@endsection
