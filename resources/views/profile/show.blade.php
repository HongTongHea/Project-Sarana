<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/assets/img/logo.jpg" type="image/x-icon" />
    <title>AngkorTech Computer</title>
    <link rel="stylesheet" href="./assets/css/website.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

</head>
<style>
    .profile-card {
        border-radius: 15px;
        border: none;
        overflow: hidden;
        transition: transform 0.3s;
    }

    .profile-card:hover {
        transform: translateY(-5px);
    }

    .profile-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .info-item {
        transition: all 0.3s ease;
    }

    .info-item:hover {
        background-color: #e9f5ff !important;
        transform: translateX(5px);
    }

    .card-header {
        border-radius: 15px 15px 0 0 !important;
    }
</style>

<body>
    <div class="container mt-4">
        <h2>Profile</h2>

        {{-- Success / error messages --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Profile picture --}}
            <div class="mb-3 text-center">
                <label for="pictureInput" style="cursor: pointer; position: relative; display: inline-block;">
                    <div style="position: relative; width: 120px; height: 120px;">
                        @if ($user->picture_url)
                            <img id="picturePreview" src="{{ Storage::url($user->picture_url) }}" alt="Profile Picture"
                                class="rounded-circle border" width="120" height="120"
                                style="object-fit: cover; border: 3px solid #ffffff !important; box-shadow: 0 0 0 3px #007bff;">
                        @else
                            <img id="picturePreview" src="{{ asset('assets/img/Default_pfp.svg.png') }}"
                                alt="Profile Picture" class="rounded-circle border" width="120" height="120"
                                style="object-fit: cover; border: 3px solid #ffffff !important; box-shadow: 0 0 0 3px #007bff;">
                        @endif

                        <!-- Camera Icon Overlay -->
                        <div
                            style="position: absolute; bottom: 5px; right: 5px; background-color: #007bff; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid white;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white"
                                viewBox="0 0 16 16">
                                <path
                                    d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z" />
                                <path
                                    d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
                            </svg>
                        </div>
                    </div>
                </label>
                <input type="file" name="picture" id="pictureInput" accept="image/*" class="d-none">
                <p class="text-muted mt-2">Click the picture to change</p>
                @error('picture')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Name --}}
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="form-control @error('email') is-invalid @enderror">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label>New Password (leave blank to keep current)</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password confirmation --}}
            <div class="mb-3">
                <label>Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            {{-- Buttons --}}
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success me-1">Save Changes</button>
                <a href="{{ route('homepage.index') }}" class="btn btn-secondary">Cancel</a>
            </div>

        </form>
    </div>

    {{-- JS to preview image instantly --}}
    <script>
        document.getElementById('pictureInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                document.getElementById('picturePreview').src = URL.createObjectURL(file);
            }
        });
    </script>

</body>

</html>
