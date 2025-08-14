<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/assets/img/logo.jpg" type="image/x-icon" />
    <title>AngkorTech Computer - Profile</title>
    <link rel="stylesheet" href="./assets/css/website.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #f8f9fa;
            --hover-color: #e9f5ff;
            --border-radius: 10px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .profile-wrapper {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 15px;
        }

        .profile-container {
            /* background: white;

            box-shadow: var(--box-shadow); */
            overflow: hidden;
        }

        .profile-content {
            display: flex;
            flex-wrap: wrap;
        }

        .profile-form-section {
            flex: 1;
            min-width: 300px;
            padding: 2rem;
            border-right: 1px solid #eee;
        }

        .profile-info-section {
            flex: 1;
            min-width: 300px;
            padding: 2rem;
        }

        .profile-header {
            margin-bottom: 2rem;
            color: #2c3e50;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .profile-picture-container {
            position: relative;
            width: 140px;
            height: 140px;
            margin: 0 auto 1rem;
        }

        .profile-picture {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 4px solid white;
            border-radius: 50%;
            box-shadow: 0 0 0 4px var(--primary-color);
            transition: var(--transition);
        }

        .profile-picture:hover {
            transform: scale(1.03);
        }

        .camera-icon {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: var(--primary-color);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
            cursor: pointer;
            transition: var(--transition);
        }

        .camera-icon:hover {
            background-color: #2980b9;
            transform: scale(1.1);
        }

        .form-section {
            margin-bottom: 1.5rem;
        }

        .info-section {
            margin-bottom: 1.5rem;
        }

        .info-title {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .info-title i {
            margin-right: 10px;
            color: var(--primary-color);
        }

        .info-content {
            background-color: var(--secondary-color);
            padding: 1rem;

        }

        .info-item {
            display: flex;
            margin-bottom: 0.5rem;
        }

        .info-label {
            font-weight: 500;
            min-width: 120px;
            color: #6c757d;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .form-control {

            border: 1px solid #ced4da;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;

            transition: var(--transition);
        }

        .btn-primary:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        .btn-secondary {


            transition: var(--transition);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
        }

        .btn-danger {

            transition: var(--transition);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
        }

        .text-muted {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .alert {}

        @media (max-width: 768px) {
            .profile-form-section {
                border-right: none;
                border-bottom: 1px solid #eee;
            }
        }
    </style>
</head>

<body>
    <div class="profile-wrapper">
        <div class="profile-container">
            <div class="profile-content">
                <!-- Left Section - Edit Form -->
                <div class="profile-form-section">
                    <div class="profile-header d-flex align-items-center">
                        <div>
                            <h2>My Profile</h2>
                            <p class="text-muted">Manage your account information</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>

                    {{-- Success / error messages --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Profile picture --}}
                        <div class="form-section text-center">
                            <div class="profile-picture-container">
                                <label for="pictureInput" style="cursor: pointer;">
                                    @if ($user->picture_url)
                                        <img id="picturePreview" src="{{ Storage::url($user->picture_url) }}"
                                            alt="Profile Picture" class="profile-picture">
                                    @else
                                        <img id="picturePreview" src="{{ asset('assets/img/Default_pfp.svg.png') }}"
                                            alt="Profile Picture" class="profile-picture">
                                    @endif
                                    <div class="camera-icon">
                                        <i class="fas fa-camera text-white"></i>
                                    </div>
                                </label>
                                <input type="file" name="picture" id="pictureInput" accept="image/*" class="d-none">
                            </div>
                            <p class="text-muted mt-2">Click the picture to change</p>
                            @error('picture')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Name --}}
                        <div class="form-section">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter your full name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form-section">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Enter your email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="form-section">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Leave blank to keep current">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password confirmation --}}
                        <div class="form-section">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Confirm your new password">
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('homepage.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>

                <!-- Right Section - User Information -->
                <div class="profile-info-section">
                    <div class="profile-header">
                        <h2>Account Information</h2>
                    </div>

                    <div class="info-section">
                        <h5 class="info-title">
                            <i class="fas fa-user-circle"></i> Personal Details
                        </h5>
                        <div class="info-content">
                            <div class="info-item">
                                <span class="info-label">Member Since:</span>
                                <span>{{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Last Updated:</span>
                                <span>{{ $user->updated_at->format('M d, Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Account Status:</span>
                                <span class="badge bg-success">Active</span>
                            </div>
                        </div>
                    </div>

                    <div class="info-section">
                        <h5 class="info-title">
                            <i class="fas fa-shield-alt"></i> Security
                        </h5>
                        <div class="info-content">
                            <div class="info-item">
                                <span class="info-label">Email Verified:</span>
                                <span>
                                    @if ($user->email_verified_at)
                                        <span class="badge bg-success">Verified</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Not Verified</span>
                                    @endif
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Last Login:</span>
                                <span>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</span>
                            </div>
                            {{-- <div class="info-item">
                                <span class="info-label">Login IP:</span>
                                <span>{{ $user->last_login_ip ?? 'Unknown' }}</span>
                            </div> --}}
                        </div>
                    </div>

                    {{-- <div class="info-section">
                        <h5 class="info-title">
                            <i class="fas fa-cog"></i> Preferences
                        </h5>
                        <div class="info-content">
                            <div class="info-item">
                                <span class="info-label">Language:</span>
                                <span>English</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Timezone:</span>
                                <span>UTC+7 (Phnom Penh)</span>
                            </div>
                            {{-- <div class="info-item">
                                <span class="info-label">Theme:</span>
                                <span>Light Mode</span>
                            </div> --}}
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    {{-- JS to preview image instantly --}}
    <script>
        document.getElementById('pictureInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('picturePreview').src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
