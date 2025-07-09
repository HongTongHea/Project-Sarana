<div class="modal fade" id="editModal{{ $customer->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <div class="d-flex justify-content-center align-items-center">
                        <h6 class="mt-3 ms-1 text-black text-uppercase" style="font-weight: 700; font-size: 16px">

                            Edit Customer
                        </h6>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-2">
                    <div class="row m-2">
                        <div class="form-group col-12 col-md-12">
                            <label for="name_{{ $customer->id }}">Full Name</label>
                            <input type="text" class="form-control" id="name_{{ $customer->id }}" name="name"
                                value="{{ $customer->name }}" required>
                        </div>

                        <div class="form-group col-12 col-md-12">
                            <label for="email_{{ $customer->id }}">Email</label>
                            <input type="email" class="form-control" id="email_{{ $customer->id }}" name="email"
                                value="{{ $customer->email }}" required>
                        </div>

                        <div class="form-group col-12 col-md-12">
                            <label for="phone_{{ $customer->id }}">Phone</label>
                            <input type="text" class="form-control" id="phone_{{ $customer->id }}" name="phone"
                                value="{{ $customer->phone }}" required>
                        </div>
                        <div class="form-group col-12 col-md-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" class="form-control" id="address" rows="3">{{ old('address', $customer->address) }}</textarea>
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
