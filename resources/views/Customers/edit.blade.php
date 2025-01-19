<div class="modal fade" id="editModal{{ $customer->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('customers.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="" class="navbar-brand"
                            height="30">
                        <h6 class="text-uppercase mt-3 ms-1 text-primary" style="font-weight: 700; font-size: 15px">
                            Clothes <span class="text-warning">Store </span> |
                            <span class="text-dark"> Edit Customer</span>
                        </h6>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row m-2">
                        <div class="form-group col-12 col-md-6">
                            <label for="first_name_{{ $customer->id }}">First Name</label>
                            <input type="text" class="form-control" id="first_name_{{ $customer->id }}"
                                name="first_name" value="{{ $customer->first_name }}" required>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="last_name_{{ $customer->id }}">Last Name</label>
                            <input type="text" class="form-control" id="last_name_{{ $customer->id }}"
                                name="last_name" value="{{ $customer->last_name }}" required>
                        </div>


                        <div class="form-group col-12 col-md-6">
                            <label for="gender_{{ $customer->id }}">Gender</label>
                            <select class="form-control" id="gender_{{ $customer->id }}" name="gender" required>
                                <option value="Male" {{ $customer->gender == 'Male' ? 'selected' : '' }}>Male
                                </option>
                                <option value="Female" {{ $customer->gender == 'Female' ? 'selected' : '' }}>Female
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="email_{{ $customer->id }}">Email</label>
                            <input type="email" class="form-control" id="email_{{ $customer->id }}" name="email"
                                value="{{ $customer->email }}" required>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="phone_{{ $customer->id }}">Phone</label>
                            <input type="text" class="form-control" id="phone_{{ $customer->id }}" name="phone"
                                value="{{ $customer->phone }}" required>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="address_{{ $customer->id }}">Address</label>
                            <textarea class="form-control" id="address_{{ $customer->id }}" name="address" rows="4" required>{{ $customer->address }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
