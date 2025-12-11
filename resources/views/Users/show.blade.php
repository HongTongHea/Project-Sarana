@extends('layouts.app')

@section('title', 'User Details')

@section('content')
    <div class="p-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm rounded-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">General Information</h5>
                    </div>

                    <form action="{{ route('profile.picture.update') }}" method="POST" enctype="multipart/form-data"
                        class="p-4">
                        @csrf

                        <!-- Profile Picture -->
                        <div class="row">
                            <div class="col-4 d-flex flex-column justify-content-center align-items-center mb-4">
                                <h3 class="text-muted">Profile Picture</h3>

                                <!-- Image Preview Container -->
                                <div class="position-relative">
                                    @if ($user && $user->picture_url)
                                        <img id="picturePreview" src="{{ Storage::url($user->picture_url) }}"
                                            alt="Profile Picture" class="rounded-circle border profile-image" width="120"
                                            height="120"
                                            style="object-fit: cover; border: 3px solid #ffffff !important; box-shadow: 0 0 0 2px #b9bbbd;">
                                    @else
                                        <!-- Show initial preview -->
                                        <div id="initialPreview"
                                            class="rounded-circle d-flex align-items-center justify-content-center bg-secondary text-white"
                                            style="width: 120px; height: 120px; font-size: 36px; font-weight: bold; border: 3px solid #ffffff !important; box-shadow: 0 0 0 3px #007bff;">
                                            {{ $user ? strtoupper(substr($user->name, 0, 1)) : 'U' }}
                                        </div>
                                        <!-- Hidden image preview for new uploads -->
                                        <img id="picturePreview" src="" alt="Profile Preview"
                                            class="rounded-circle border profile-image d-none" width="120" height="120"
                                            style="object-fit: cover; border: 3px solid #ffffff !important; box-shadow: 0 0 0 3px #007bff;">
                                    @endif
                                </div>

                                <div class="mt-3 d-flex flex-column align-items-center">
                                    <label for="profilePicture" class="btn btn-outline-secondary btn-hover btn-sm">
                                        <i class="fa-solid fa-upload me-1"></i>Upload Picture
                                    </label>
                                    <input type="file" name="profile_picture" id="profilePicture" class="d-none"
                                        accept="image/*" onchange="previewImage(event)">

                                    <div class="mt-2 text-center">
                                        <small id="fileName" class="text-muted">No file chosen</small>
                                        <small id="fileSize" class="text-muted d-block"></small>
                                    </div>

                                    <!-- Cancel Button (only shows when new image is selected) -->
                                    <button type="button" id="cancelImageBtn"
                                        class="btn btn-outline-secondary btn-sm mt-2 d-none w-50"
                                        onclick="cancelImageSelection()">
                                        <i class="fa-solid fa-xmark me-1"></i>Cancel
                                    </button>
                                </div>
                            </div>

                            <!-- User Info -->
                            <div class="col-8">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" value="{{ $user ? $user->name : 'N/A' }}"
                                        disabled>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <input type="text" class="form-control" value="{{ $user ? $user->role : 'N/A' }}"
                                        disabled>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="{{ $user ? $user->email : 'N/A' }}"
                                        disabled>
                                </div>

                                <!-- Created / Updated -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Created At</label>
                                        <input type="text" class="form-control"
                                            value="{{ $user && $user->created_at ? $user->created_at->setTimezone('Asia/Phnom_Penh')->format('M d, Y h:i A') : 'N/A' }}"
                                            disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Updated At</label>
                                        <input type="text" class="form-control"
                                            value="{{ $user && $user->updated_at ? $user->updated_at->setTimezone('Asia/Phnom_Penh')->format('M d, Y h:i A') : 'N/A' }}"
                                            disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm me-2">Back</a>
                            <button type="submit" class="btn btn-primary btn-sm"><i
                                    class="fa-solid fa-floppy-disk me-1"></i>Save</button>
                        </div>
                    </form>
                </div>

                <!-- Delete Account Section - Only show if user exists -->
                @if ($user)
                    <div class="card shadow-sm rounded-0 mt-4">
                        <div class="card-header bg-white border-0">
                            <h5 class="mb-0 text-danger">Account status</h5>
                        </div>
                        <div class="card-body">
                            <p>Delete my account and all the information it contains.</p>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <div class="d-flex justify-content-end mb-3">
                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                            class="fa-solid fa-trash me-1"></i>Delete account</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('picturePreview');
            const initialPreview = document.getElementById('initialPreview');
            const fileNameDisplay = document.getElementById('fileName');
            const fileSizeDisplay = document.getElementById('fileSize');
            const cancelBtn = document.getElementById('cancelImageBtn');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();

                // Validate file type
                if (!file.type.match('image.*')) {
                    alert('Please select an image file (JPEG, PNG, etc.)');
                    input.value = '';
                    return;
                }

                // Validate file size (max 2MB)
                const maxSize = 2 * 1024 * 1024; // 2MB
                if (file.size > maxSize) {
                    alert('Image size should not exceed 2MB');
                    input.value = '';
                    return;
                }

                // Show file info
                fileNameDisplay.textContent = file.name;
                fileSizeDisplay.textContent = formatFileSize(file.size);

                reader.onload = function(e) {
                    // Hide initial preview if exists
                    if (initialPreview) {
                        initialPreview.classList.add('d-none');
                    }

                    // Show image preview
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');

                    // Show cancel button
                    cancelBtn.classList.remove('d-none');
                };

                reader.readAsDataURL(file);
            }
        }

        function cancelImageSelection() {
            const input = document.getElementById('profilePicture');
            const preview = document.getElementById('picturePreview');
            const initialPreview = document.getElementById('initialPreview');
            const fileNameDisplay = document.getElementById('fileName');
            const fileSizeDisplay = document.getElementById('fileSize');
            const cancelBtn = document.getElementById('cancelImageBtn');

            // Reset file input
            input.value = '';

            // Hide preview
            preview.classList.add('d-none');
            preview.src = '';

            // Show initial preview
            if (initialPreview) {
                initialPreview.classList.remove('d-none');
            }

            // Reset file info
            fileNameDisplay.textContent = 'No file chosen';
            fileSizeDisplay.textContent = '';

            // Hide cancel button
            cancelBtn.classList.add('d-none');
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';

            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));

            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Add click event to the image to trigger file input
        document.addEventListener('DOMContentLoaded', function() {
            const profileImage = document.querySelector('.profile-image');
            const fileInput = document.getElementById('profilePicture');

            if (profileImage) {
                profileImage.addEventListener('click', function() {
                    fileInput.click();
                });

                // Add hover effect
                profileImage.style.cursor = 'pointer';
                profileImage.addEventListener('mouseenter', function() {
                    this.style.opacity = '0.8';
                });
                profileImage.addEventListener('mouseleave', function() {
                    this.style.opacity = '1';
                });
            }
        });
    </script>

    <style>
        .profile-image:hover {
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .btn-hover:hover {
            background-color: #f8f9fa;
            transition: background-color 0.3s ease;
        }

        #cancelImageBtn:hover {
            background-color: #da1212;
            color: white;
            transition: all 0.3s ease;
        }
    </style>
@endsection
