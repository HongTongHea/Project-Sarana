@extends('layouts.app')

@section('content')
    <div class="container mt-3" data-aos="fade-down" data-aos-duration="1000">
        <h3 class="m-3">Add New Staffs</h3>
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

                <form action="{{ route('staffs.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label for="user_id">Staff Name</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="gender">Gender</label>
                            <select type="text" class="form-select form-control" id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>

                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="position">Position</label>
                            <input type="text" name="position" id="position" class="form-control" required>
                        </div>



                        <div class="form-group col-12 col-md-6">
                            <label for="department">Department</label>
                            <input type="text" name="department" id="department" class="form-control" required>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="salary">Salary</label>
                            <input type="number" name="salary" id="salary" class="form-control" step="0.01"
                                required>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="date_hired">Date Hired</label>
                            <input type="date" name="date_hired" id="date_hired" class="form-control" required>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="contact_number">Contact Number</label>
                            <input type="text" name="contact_number" id="contact_number" class="form-control" required>
                        </div>  
                        <div class="form-group col-12 col-md-6">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="4" required></textarea>
                        </div>

                    </div>
                    <a href="{{ route('staffs.index') }}"
                        class="btn btn-secondary mt-3 btn-sm float-end rounded-5">Cancel</a>
                    <button type="submit" class="btn btn-primary mt-3 btn-sm me-1 float-end rounded-5">Add
                        Staff</button>
                </form>
            </div>
        </div>
    </div>


@endsection
