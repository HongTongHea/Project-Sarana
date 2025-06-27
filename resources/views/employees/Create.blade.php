<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/logostore2.png') }}" alt="" class="navbar-brand"
                        height="40">
                    <h6 class="text-uppercase mt-4 ms-1 text-primary" style="font-weight: 700; font-size: 16px">
                        Clothes <span class="text-warning">Store </span> |
                        <span class="text-dark"> Create Employee</span>
                    </h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ old('name') }}" required placeholder="Enter employee name">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        value="{{ old('email') }}" required placeholder="Enter email address">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" id="phone"
                                        value="{{ old('phone') }}" required placeholder="Enter phone number">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label for="position" class="form-label">Position</label>
                                    <input type="text" name="position" class="form-control" id="position"
                                        value="{{ old('position') }}" required placeholder="Enter position">
                                </div>

                                <div class="form-group col-12 col-md-12">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea name="address" class="form-control" id="address" rows="3" required>{{ old('address') }}</textarea>
                                </div>

                                <div class="form-group col-12 col-md-12">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" class="form-select form-control" id="status" required>
                                        <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group col-12 col-md-12" style="margin-left: 14px">
                                <label for="picture_url">Employee Photo:
                                    @if ($errors->has('picture_url'))
                                        <label class="text-danger mt-1">{{ $errors->first('picture_url') }}</label>
                                    @endif
                                </label>

                                <input type="file" class="form-control d-none" name="picture_url" id="picture_url"
                                    accept="image/*" onchange="showPreview(event)"
                                    style="width: 350px; height: 350px; object-fit: cover; border: 1px solid #ccc; border-radius: 5px;">

                                <div id="preview" onclick="triggerFileInput()"
                                    style="cursor: pointer; width: 350px; height: 350px; display: flex; justify-content: center; align-items: center;">
                                    <img id="imagePreview" src="/assets/img/image.png" alt="Image Preview"
                                        class="img-fluid"
                                        style="width: 100%; height: 100%; object-fit: cover; border: 1px solid #ccc; border-radius: 5px;" />
                                </div>
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
</div>

<script>
    function triggerFileInput() {
        document.getElementById('picture_url').click();
    }

    function showPreview(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imagePreview = document.getElementById('imagePreview');
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>
