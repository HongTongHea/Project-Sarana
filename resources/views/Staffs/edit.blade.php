<div class="modal fade" id="editModal{{ $staff->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('staffs.update', $staff->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/img/logostore2.png') }}" alt="" class="navbar-brand"
                            height="30">
                        <h6 class="text-uppercase mt-4 ms-1 text-primary" style="font-weight: 700; font-size: 16px">
                            Clothes <span class="text-warning">Store </span> |
                            <span class="text-dark"> Edit Staff</span>
                        </h6>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row m-2">
                        <div class="form-group col-12 col-md-6">
                            <label for="user_id">Staff Name</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $staff->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="gender">Gender</label>
                            <select type="text" class="form-select form-control" id="gender" name="gender">
                                <option value="Male" {{ $staff->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $staff->gender == 'Female' ? 'selected' : '' }}>Female
                                </option>
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
                        <div class="form-group col-12 col-md-12">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ $staff->address }}" required>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
