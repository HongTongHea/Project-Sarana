<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile</div>

                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        @if ($user->picture_url)
                            <img src="{{ Storage::url(Auth::user()->picture_url) }}" alt="Profile Picture"
                                class="avatar-img rounded-5" width="80" height="80" style="object-fit: cover;">
                        @else
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-user text-white fa-2x"></i>
                            </div>
                        @endif
                        <div>
                            <h4>{{ $user->name }}</h4>
                            <p class="text-muted mb-0">{{ $user->email }}</p>
                        </div>
                    </div>

                    {{-- <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a> --}}
                </div>
            </div>
        </div>
    </div>
</div>
