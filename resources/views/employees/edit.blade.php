<div class="modal fade" id="editModal{{ $employee->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="mt-3 ms-1 text-black text-uppercase" style="font-weight: 700; font-size: 16px">
                        Edit Employee
                    </h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('employees.update', $employee->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-12 col-md-7">
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ old('name', $employee->name) }}" required
                                        placeholder="Enter employee name">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        value="{{ old('email', $employee->email) }}" required
                                        placeholder="Enter email address">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" id="phone"
                                        value="{{ old('phone', $employee->phone) }}" required
                                        placeholder="Enter phone number">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label for="position" class="form-label">Position</label>
                                    <input type="text" name="position" class="form-control" id="position"
                                        value="{{ old('position', $employee->position) }}" required
                                        placeholder="Enter position">
                                </div>

                                <div class="form-group col-12 col-md-12">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" class="form-select form-control" id="status" required>
                                        <option value="1"
                                            {{ old('status', $employee->status) == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0"
                                            {{ old('status', $employee->status) == 0 ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group col-12 col-md-12">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea name="address" class="form-control" id="address" rows="3" required>{{ old('address', $employee->address) }}</textarea>
                                </div>

                            </div>
                        </div>

                        <div class="col-12 col-md-5 p-0 mt-md-0 mt-3">
                            <div class="form-group col-12 col-md-12" style="margin-left: 14px">
                                <label for="picture_url">Click to upload image
                                    @if ($errors->has('picture_url'))
                                        <label class="text-danger mt-1">{{ $errors->first('picture_url') }}</label>
                                    @endif
                                </label>

                                <!-- File input for image upload -->
                                <input type="file" class="form-control d-none" name="picture_url"
                                    id="edit_picture_url_{{ $employee->id }}" accept="image/*"
                                    onchange="showEditPreview(event, {{ $employee->id }})">

                                <!-- Image preview container -->
                                <div id="edit_preview_{{ $employee->id }}"
                                    onclick="triggerEditFileInput({{ $employee->id }})"
                                    style="cursor: pointer; width: 430px; height: 350px; display: flex; justify-content: center; align-items: center; border: 1px solid #ccc; border-radius: 5px;">
                                    <img id="edit_imagePreview_{{ $employee->id }}"
                                        src="{{ $employee->picture_url ? asset('storage/' . $employee->picture_url) : '/assets/img/image.png' }}"
                                        alt="Image Preview" class="img-fluid"
                                        style="width: 100%; height: 100%; object-fit: cover;" />
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
    // Function to show the image preview when a file is selected
    function showEditPreview(event, employeeId) {
        const fileInput = event.target;
        const previewImage = document.getElementById(`edit_imagePreview_${employeeId}`);

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result; // Update preview with the selected image
            };
            reader.readAsDataURL(fileInput.files[0]); // Read the file as a Data URL
        }
    }

    // Function to trigger the file input click when the preview is clicked
    function triggerEditFileInput(employeeId) {
        const fileInput = document.getElementById(`edit_picture_url_${employeeId}`);
        fileInput.click(); // Trigger the file input dialog
    }
</script>
