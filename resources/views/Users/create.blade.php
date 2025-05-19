<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/logostore2.png') }}" alt="" class="navbar-brand"
                        height="40">
                    <h6 class="text-uppercase mt-4 ms-1 text-primary" style="font-weight: 700; font-size: 16px">
                        Clothes <span class="text-warning">Store </span> |
                        <span class="text-dark"> Create User</span>
                    </h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row">

                                <div class="form-group col-12 col-md-6">
                                    <label for="name" class="form-label">Username</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ old('name') }}" required placeholder="Enter username">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label for="email">Email
                                        @if ($errors->has('email'))
                                            <label class="text-danger mt-1">{{ $errors->first('email') }}</label>
                                        @endif
                                    </label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ old('email') }}" placeholder="Enter email" required>
                                </div>

                                <div class="form-group col-12 col-md-12">
                                    <label for="role" class="form-label">Role</label>
                                    <select name="role" class="form-select form-control" id="role" required>
                                        <option value="">Select Role</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin
                                        </option>
                                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff
                                        </option>
                                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>
                                            Customer</option>
                                    </select>
                                </div>

                                <div class="form-group col-12 col-md-12">
                                    <label for="password">Password
                                        @if ($errors->has('password'))
                                            <label class="text-danger mt-1">{{ $errors->first('password') }}</label>
                                        @endif
                                    </label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        {{ isset($user) ? '' : 'required' }} required placeholder="Enter password" />
                                </div>
                                <div class="form-group col-12 col-md-12">
                                    <label for="password_confirmation">Confirm Password
                                        @if ($errors->has('password_confirmation'))
                                            <label
                                                class="text-danger mt-1">{{ $errors->first('password_confirmation') }}</label>
                                        @endif
                                    </label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" {{ isset($user) ? '' : 'required' }} required
                                        placeholder="Enter confirm password" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group col-12 col-md-12" style="margin-left: 14px">
                                <label for="picture_url">Upload Image:
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
