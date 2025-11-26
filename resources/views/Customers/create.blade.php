<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <div class="d-flex justify-content-center align-items-center">
                        <h6 class="mt-3 ms-1 text-black text-uppercase" style="font-weight: 700; font-size: 16px">
                            Create Customer
                        </h6>
                    </div>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-2">
                    <div class="row m-2">
                        <div class="form-group col-12 col-md-6">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" id="first_name" name="name"
                                value="{{ old('name') }}" required placeholder="Enter full name">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" required placeholder="Enter email">
                        </div>
                        <div class="form-group col-12 col-md-12">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ old('phone') }}" required placeholder="Enter phone">
                        </div>
                        <div class="form-group col-12 col-md-12">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" value="{{ old('address') }}" rows="3" required
                                placeholder="Enter address">
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                            class="fas fa-times me-1"></i>Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm"><i
                            class="fa-solid fa-floppy-disk me-1"></i>Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
