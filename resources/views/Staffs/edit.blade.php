@extends('layouts.app')

@section('title', 'Update Staff')

@section('content')
    <div class="container mt-3" data-aos="fade-down" data-aos-duration="1000">
        <h3 class="m-3">Update Staff</h3>
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

                <form action="{{ route('staffs.update', $staff->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label for="user_id">Staff Name</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $staff->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="gender">Gender</label>
                            <select type="text" class="form-select form-control" id="gender" name="gender">
                                <option value="Male" {{ $staff->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $staff->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>

                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="position">Position</label>
                            <input type="text" name="position" id="position" class="form-control"
                                value="{{ $staff->position }}" required>
                        </div>



                        <div class="form-group col-12 col-md-6">
                            <label for="department">Department</label>
                            <input type="text" name="department" id="department" class="form-control"
                                value="{{ $staff->department }}" required>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="salary">Salary</label>
                            <input type="number" name="salary" id="salary" class="form-control" step="0.01"
                                value="{{ $staff->salary }}" required>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="date_hired">Date Hired</label>
                            <input type="date" name="date_hired" id="date_hired" class="form-control"
                                value="{{ $staff->date_hired }}" required>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="contact_number">Contact Number</label>
                            <input type="text" name="contact_number" id="contact_number" class="form-control"
                                value="{{ $staff->contact_number }}" required>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" onchange="this.form.submit()">
                                <option value="active" {{ $staff->status === 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ $staff->status === 'inactive' ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="4" required> {{ $staff->address }}</textarea>
                        </div>

                    </div>
                    <a href="{{ route('staffs.index') }}"
                        class="btn btn-secondary mt-3 btn-sm float-end rounded-5">Cancel</a>
                    <button type="submit" class="btn btn-primary mt-3 btn-sm me-1 float-end rounded-5">Upate
                        Staff</button>
                </form>
            </div>
        </div>
    </div>


@endsection
