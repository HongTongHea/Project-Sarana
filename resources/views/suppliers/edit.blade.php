<div class="modal fade" id="editModal{{ $supplier->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel-{{ $supplier->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="mt-3 ms-1 text-black text-uppercase" style="font-weight: 700; font-size: 16px">
                        Edit Supplier
                    </h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row m-2">
                        <div class="form-group col-12 col-md-6">
                            <label for="name">Supplier Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $supplier->name }}" required>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ $supplier->email }}">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ $supplier->phone }}" required>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="contact_person">Contact Person</label>
                            <input type="text" class="form-control" id="contact_person" name="contact_person"
                                value="{{ $supplier->contact_person }}" required>
                        </div>

                        <div class="form-group col-12 col-md-12">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required>{{ $supplier->address }}</textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
