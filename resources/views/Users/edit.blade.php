<div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="text-uppercase mt-3 ms-1 text-black" style="font-weight: 700; font-size: 16px">
                        Edit User
                    </h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pe-0">
                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-12 col-md-7">
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
                                        <option value="manager"
                                            {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>
                                            Manager</option>
                                        <option value="cashier"
                                            {{ old('role', $user->role) == 'cashier' ? 'selected' : '' }}>
                                            Cashier</option>
                                        <option value="customer"
                                            {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>
                                            Customer
                                        </option>
                                    </select>
                                </div>

                                <!-- Password -->
                                <div class="form-group col-12 col-md-12">
                                    <label for="password_{{ $user->id }}">Password</label>
                                    <div class="position-relative">
                                        <input type="password" name="password" id="password_{{ $user->id }}"
                                            class="form-control" placeholder="Enter new password or keep existing">
                                        <i class="fa-solid fa-lock position-absolute"
                                            id="togglePassword_{{ $user->id }}"
                                            style="top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;"></i>
                                    </div>
                                    <small id="passwordHint_{{ $user->id }}" class="text-muted d-none">
                                        Password is required, must be at least 8 characters.
                                    </small>
                                    @if ($errors->has('password'))
                                        <label class="text-danger mt-1">{{ $errors->first('password') }}</label>
                                    @endif
                                </div>

                                <!-- Password Confirmation -->
                                <div class="form-group col-12 col-md-12">
                                    <label for="password_confirmation_{{ $user->id }}">Confirm Password</label>
                                    <div class="position-relative">
                                        <input type="password" name="password_confirmation"
                                            id="password_confirmation_{{ $user->id }}" class="form-control"
                                            placeholder="Confirm password">
                                        <i class="fa-solid fa-lock position-absolute"
                                            id="togglePasswordConfirm_{{ $user->id }}"
                                            style="top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;"></i>
                                    </div>
                                    <small id="passwordConfirmHint_{{ $user->id }}" class="text-muted d-none">
                                        Password must match the confirmation field.
                                    </small>
                                    @if ($errors->has('password_confirmation'))
                                        <label
                                            class="text-danger mt-1">{{ $errors->first('password_confirmation') }}</label>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-5 p-0 mt-md-0 mt-3">
                            <div class="form-group">
                                <label for="picture_url">Click to upload image
                                    @if ($errors->has('picture_url'))
                                        <label class="text-danger mt-1">{{ $errors->first('picture_url') }}</label>
                                    @endif
                                </label>
                                <!-- File input for image upload -->
                                <input type="file" class="form-control d-none" name="picture_url"
                                    id="edit_picture_url_{{ $user->id }}" accept="image/*"
                                    onchange="showEditPreview(event, {{ $user->id }})">

                                <!-- Image preview container -->
                                <div id="edit_preview_{{ $user->id }}"
                                    onclick="triggerEditFileInput({{ $user->id }})"
                                    style="cursor: pointer; width: 430px; height: 350px; display: flex; justify-content: center; align-items: center; border: 1px solid #ccc; border-radius: 5px;">
                                    <img id="edit_imagePreview_{{ $user->id }}"
                                        src="{{ $user->picture_url ? asset('storage/' . $user->picture_url) : '/assets/img/image.png' }}"
                                        alt="Image Preview" class="img-fluid"
                                        style="width: 100%; height: 100%; object-fit: cover;" />
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                                class="fas fa-times me-1"></i>Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm"><i
                                class="fa-solid fa-floppy-disk me-1"></i>Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ---- PASSWORD HINTS ----
        document.querySelectorAll('[id^="password_"]').forEach(passwordInput => {
            const userId = passwordInput.id.replace('password_', '');
            const passwordHint = document.getElementById('passwordHint_' + userId);

            if (passwordHint) {
                passwordInput.addEventListener('focus', () => passwordHint.classList.remove('d-none'));
                passwordInput.addEventListener('blur', () => passwordHint.classList.add('d-none'));
            }
        });

        document.querySelectorAll('[id^="password_confirmation_"]').forEach(confirmInput => {
            const userId = confirmInput.id.replace('password_confirmation_', '');
            const confirmHint = document.getElementById('passwordConfirmHint_' + userId);

            if (confirmHint) {
                confirmInput.addEventListener('focus', () => confirmHint.classList.remove('d-none'));
                confirmInput.addEventListener('blur', () => confirmHint.classList.add('d-none'));
            }
        });

        // ---- TOGGLE PASSWORD VISIBILITY ----
        document.querySelectorAll('[id^="togglePassword_"]').forEach(toggle => {
            const userId = toggle.id.replace('togglePassword_', '');
            const passwordInput = document.getElementById('password_' + userId);

            if (passwordInput) {
                toggle.addEventListener('click', function() {
                    const type = passwordInput.type === 'password' ? 'text' : 'password';
                    passwordInput.type = type;
                    this.classList.toggle('fa-lock');
                    this.classList.toggle('fa-unlock');
                });
            }
        });

        document.querySelectorAll('[id^="togglePasswordConfirm_"]').forEach(toggle => {
            const userId = toggle.id.replace('togglePasswordConfirm_', '');
            const confirmInput = document.getElementById('password_confirmation_' + userId);

            if (confirmInput) {
                toggle.addEventListener('click', function() {
                    const type = confirmInput.type === 'password' ? 'text' : 'password';
                    confirmInput.type = type;
                    this.classList.toggle('fa-lock');
                    this.classList.toggle('fa-unlock');
                });
            }
        });

        // ---- IMAGE PREVIEW FUNCTIONS ----
        window.showEditPreview = function(event, userId) {
            const fileInput = event.target;
            const previewImage = document.getElementById(`edit_imagePreview_${userId}`);
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(fileInput.files[0]);
            }
        }

        window.triggerEditFileInput = function(userId) {
            const fileInput = document.getElementById(`edit_picture_url_${userId}`);
            fileInput.click();
        }

    });
</script>
