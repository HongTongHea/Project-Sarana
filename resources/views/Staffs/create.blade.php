
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-0">
            <form action="{{ route('staffs.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/img/logostore2.png') }}" alt="" class="navbar-brand"
                            height="30">
                        <h6 class="text-uppercase mt-4 ms-1 text-primary" style="font-weight: 700; font-size: 16px">
                            Clothes <span class="text-warning">Store </span> |
                            <span class="text-dark"> Create Staff</span>
                        </h6>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row m-2">
                        <div class="form-group col-12 col-md-6">
                            <label for="user_id">Staff Name</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">Select Name</option>
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
                            <input type="text" name="position" id="position" class="form-control" placeholder="Enter Position" required>
                        </div>



                        <div class="form-group col-12 col-md-6">
                            <label for="department">Department</label>
                            <input type="text" name="department" id="department" class="form-control" placeholder="Enter Department" required>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="salary">Salary</label>
                            <input type="number" name="salary" id="salary" class="form-control" step="0.01" placeholder="Enter Salary" required>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="date_hired">Date Hired</label>
                            <input type="date" name="date_hired" id="date_hired" class="form-control" placeholder="Enter Date Hired" required>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="contact_number">Contact Number</label>
                            <input type="text" name="contact_number" id="contact_number" class="form-control" placeholder="Enter Contact Number" required>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-12">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" required>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
