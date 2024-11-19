@extends('layouts.app')

@section('title', 'User Details')

@section('content')
    {{-- <div class="card rounded-0 shadow ">
        <div class="card-body">
            <h1>User Details</h1>
            <div class="border p-3">
                <form action="{{ route('profile.picture.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row ">
                        <div class="col-12 col-md-6">
                            @if ($user->picture_url)
                                <img src="{{ asset('storage/' . $user->picture_url) }}" alt="{{ $user->name }}"
                                    class="object-fit-cover object-center" width="20%">
                            @else
                                No picture available <img src="{{ asset('storage/' . $user->profile_picture) }}"
                                    alt="">
                            @endif

                            <div class="input-group mt-3">
                                <input type="file" name="profile_picture" id="profilePicture" style="display: none;"
                                    required onchange="displayFileName()">

                                <!-- Custom button to trigger file input -->
                                <button type="button" class="btn btn-sm rounded-4 border border-1 border-dark "
                                    onclick="document.getElementById('profilePicture').click()">
                                    Upload Picture
                                </button>

                            </div>
                        </div>

                        <h4 class="mb-4 mt-4" id="fileName">Name: {{ $user->name }}</h4>
                        <h4 class="mb-4">Email: {{ $user->email }}</h4>
                        <h4 class="mb-4">Role: {{ ucfirst($user->role) }}</h4>
                        <h4 class="mb-4">Created At: {{ $user->created_at }}</h4>
                        <h4 class="mb-4">Updated At: {{ $user->updated_at }}</h4>

                    </div>




            </div>
            <button type="submit" class="btn btn-primary btn-sm float-end m-1 rounded-5">Save</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm float-end m-1 rounded-5">Back</a>
            </form>
        </div>
    </div> --}}
    <div class="container mt-3">
        <div class="col-md-12">
            <form action="{{ route('profile.picture.update') }}" method="POST" enctype="multipart/form-data">
                <div class="card card-profile card-plain rounded-0">

                    <div class="card-header" style="background-image: url('/assets/img/examples/product12.jpeg')">
                        <div class="profile-picture">
                            <div class="avatar avatar-xl">

                                @if ($user->picture_url)
                                    <img src="{{ asset('storage/' . $user->picture_url) }}" alt="{{ $user->name }}"
                                        class="object-fit-cover object-center avatar-img rounded-circle " width="20%">
                                @else
                                    No picture available <img src="{{ asset('storage/' . $user->profile_picture) }}"
                                        alt="">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="user-profile text-center">

                            @csrf
                            <div class="name">{{ $user->name }}</div>
                            <div class="job">Roles: {{ $user->role }}</div>
                            <div class="desc">Email: {{ $user->email }}</div>
                            <div class="social-media">
                                <a class="btn btn-info btn-twitter btn-sm btn-link" href="#">
                                    <span class="btn-label just-icon"><i class="icon-social-twitter"></i>
                                    </span>
                                </a>
                                <a class="btn btn-primary btn-sm btn-link" rel="publisher" href="#">
                                    <span class="btn-label just-icon"><i class="icon-social-facebook"></i>
                                    </span>
                                </a>
                                <a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#">
                                    <span class="btn-label just-icon"><i class="icon-social-instagram"></i>
                                    </span>
                                </a>
                            </div>
                            <div class="view-profile">
                                <input type="file" name="profile_picture" id="profilePicture" style="display: none;"
                                    required onchange="displayFileName()">
                                    
                                <button type="button" class="btn btn-secondary "
                                    onclick="document.getElementById('profilePicture').click()">
                                    Upload Picture
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer rounded-0">
                        <div class="row user-stats text-center">
                            <div class="col">
                                <div class="title">Create at</div>
                                <div class="number">{{ $user->created_at }}</div>
                            </div>
                            <div class="col">
                                <div class="title">Updated at</div>
                                <div class="number">{{ $user->updated_at }}</div>
                            </div>

                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-primary btn-sm float-end m-1 rounded-5">Save</button>
                                <a href="{{ route('dashboard') }}"
                                    class="btn btn-secondary btn-sm float-end m-1 rounded-5">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
