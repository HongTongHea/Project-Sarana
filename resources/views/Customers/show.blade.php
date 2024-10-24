@extends('layouts.app')

@section('title', 'Customer Details')

@section('content')
    <div class="card rounded-0">
        <div class="card-body">
            <h1>Customer Details</h1>

            <div class="card mt-4 rounded-0 w-50 bg-dark text-white">
                <div class="card-header">
                    <h3>Name: {{ $customer->first_name }} {{ $customer->last_name }}</h3>
                </div>
                <div class="card-body">
                    <p><strong>Phone:</strong> {{ $customer->phone }}</p>
                    <p><strong>Address:</strong> {{ $customer->address }}</p>
                    <p><strong>Email:</strong> {{ $customer->email }}</p>
                    <p><strong>Created At:</strong> {{ $customer->created_at->format('d-m-Y H:i') }}</p>
                    <p><strong>Updated At:</strong> {{ $customer->updated_at->format('d-m-Y H:i') }}</p>

                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">Back to List</a>

                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
