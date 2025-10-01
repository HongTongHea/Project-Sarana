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
                            <div class="col-4 d-flex flex-column align-items-center mb-4">
                                <h3 class="text-muted">Profile Picture</h3>
                                @if ($user->picture_url)
                                    <img src="{{ asset('storage/' . $user->picture_url) }}" alt="{{ $user->name }}"
                                        class="rounded-circle img-thumbnail"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-secondary text-white"
                                        style="width: 100px; height: 100px; font-size: 36px; font-weight: bold;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif

                                <div class="mt-3 d-flex justify-content-start">
                                    <label for="profilePicture" class="btn btn-outline-secondary btn-hover btn-sm">
                                        Upload Picture
                                    </label>
                                    <input type="file" name="profile_picture" id="profilePicture" class="d-none"
                                        onchange="displayFileName()">
                                    <small id="fileName" class="d-block mt-2 text-muted"></small>
                                </div>
                            </div>

                            <!-- User Info -->
                            <div class="col-8">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <input type="text" class="form-control" value="{{ $user->role }}" disabled>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                </div>

                                <!-- Created / Updated -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Created At</label>
                                        <input type="text" class="form-control" value="{{ $user->created_at }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Updated At</label>
                                        <input type="text" class="form-control" value="{{ $user->updated_at }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm me-2">Back</a>
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                        </div>
                    </form>
                </div>

                <!-- Delete Account Section -->
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
                                <button type="submit" class="btn btn-danger btn-sm">Delete account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function displayFileName() {
            const fileInput = document.getElementById('profilePicture');
            const fileNameDisplay = document.getElementById('fileName');
            fileNameDisplay.textContent = fileInput.files[0] ? fileInput.files[0].name : 'No file chosen';
        }
    </script>
@endsection
