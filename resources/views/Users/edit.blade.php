<div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/logostore2.png') }}" alt="" class="navbar-brand"
                        height="40">
                    <h6 class="text-uppercase mt-4 ms-1 text-primary" style="font-weight: 700; font-size: 16px">
                        Clothes <span class="text-warning">Store </span> |
                        <span class="text-dark"> Edit User</span>
                    </h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="name" class="form-label">Username</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ old('name', $user->name) }}" required placeholder="Enter username">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        value="{{ old('email', $user->email) }}" required placeholder="Enter email">
                                </div>

                                <div class="form-group col-12 col-md-12">
                                    <label for="role" class="form-label">Role</label>
                                    <select name="role" class="form-select form-control" id="role" required>
                                        <option value="">Select Role</option>
                                        <option value="admin"
                                            {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                            Admin</option>
                                        <option value="staff"
                                            {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>
                                            Staff</option>
                                        <option value="customer"
                                            {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>
                                            Customer
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group col-12 col-md-12">
                                    <label for="password">Password
                                        @if ($errors->has('password'))
                                            <label class="text-danger mt-1">{{ $errors->first('password') }}</label>
                                        @endif
                                    </label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        {{ isset($user) ? '' : 'required' }} placeholder="Enter password" />
                                </div>

                                <div class="form-group col-12 col-md-12">
                                    <label for="password_confirmation">Confirm Password
                                        @if ($errors->has('password_confirmation'))
                                            <label
                                                class="text-danger mt-1">{{ $errors->first('password_confirmation') }}</label>
                                        @endif
                                    </label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" {{ isset($user) ? '' : 'required' }}
                                        placeholder="Enter confirm password">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group col-12 col-md-12" style="margin-left: 14px">
                                <label for="picture_url">Upload Image:</label>
                                @if ($errors->has('picture_url'))
                                    <label class="text-danger mt-1">{{ $errors->first('picture_url') }}</label>
                                @endif

                                <!-- File input for image upload -->
                                <input type="file" class="form-control d-none" name="picture_url"
                                    id="edit_picture_url_{{ $user->id }}" accept="image/*"
                                    onchange="showEditPreview(event, {{ $user->id }})">

                                <!-- Image preview container -->
                                <div id="edit_preview_{{ $user->id }}"
                                    onclick="triggerEditFileInput({{ $user->id }})"
                                    style="cursor: pointer; width: 350px; height: 350px; display: flex; justify-content: center; align-items: center; border: 1px solid #ccc; border-radius: 5px;">
                                    <img id="edit_imagePreview_{{ $user->id }}"
                                        src="{{ $user->picture_url ? asset('storage/' . $user->picture_url) : '/assets/img/image.png' }}"
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
    function showEditPreview(event, productId) {
        const fileInput = event.target;
        const previewImage = document.getElementById(`edit_imagePreview_${productId}`);

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result; // Update preview with the selected image
            };
            reader.readAsDataURL(fileInput.files[0]); // Read the file as a Data URL
        }
    }

    // Function to trigger the file input click when the preview is clicked
    function triggerEditFileInput(productId) {
        const fileInput = document.getElementById(`edit_picture_url_${productId}`);
        fileInput.click(); // Trigger the file input dialog
    }
</script>
