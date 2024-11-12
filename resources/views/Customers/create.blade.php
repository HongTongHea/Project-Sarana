@extends('layouts.app')

@section('content')
    <div class="container mt-3" data-aos="fade-down" data-aos-duration="1000">
        <h3 class="m-3">Add New Customer</h3>
        <div class="card">
            <div class="card-body">


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

                <form action="{{ route('customers.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name"
                                value="{{ old('first_name') }}" required>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name"
                                value="{{ old('last_name') }}" required>
                        </div>
                        
                        <div class="form-group col-12 col-md-6">
                            <label for="gender">Gender</label>
                            <select type="text" class="form-select form-control" id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" required>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ old('phone') }}" required>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="4" required>{{ old('address') }}</textarea>
                        </div>
                    </div>
                    <a href="{{ route('customers.index') }}"
                        class="btn btn-secondary mt-3 btn-sm float-end rounded-5">Cancel</a>
                    <button type="submit" class="btn btn-primary mt-3 btn-sm me-1 float-end rounded-5">Add
                        Customer</button>
                </form>
            </div>
        </div>
    </div>


@endsection
