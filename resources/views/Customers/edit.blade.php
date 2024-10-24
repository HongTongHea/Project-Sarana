@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
    <div class="card rounded-0">
        <div class="card-body">
            <h1>Add New Customer</h1>

            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-12 col-md-6">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                            value="{{ $customer->first_name }}" required>
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                            value="{{ $customer->last_name }}" required>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ $customer->email }}" required>
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            value="{{ $customer->phone }}" required>
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="4" required>{{ $customer->address }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3 btn-sm">Update Customer</button>
                <a href="{{ route('customers.index') }}" class="btn btn-secondary mt-3 btn-sm">Cancel</a>
            </form>
        </div>
    </div>
@endSection
