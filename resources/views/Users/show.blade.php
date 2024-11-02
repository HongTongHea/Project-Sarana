@extends('layouts.app')

@section('title', 'User Details')

@section('content')
    <div class="card rounded-0 shadow ">
        <div class="card-body">
            <h1>User Details</h1>
            <table class="table table-responsive table-sm table-hover border">
                <form action="{{ route('profile.picture.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <tr>
                        <th>
                            @if ($user->picture_url)
                                <img src="{{ asset('storage/' . $user->picture_url) }}" alt="{{ $user->name }}"
                                    class="avatar-img avatar-lg rounded-5 object-fit-cover object-center" width="100%">
                            @else
                                No picture available <img src="{{ asset('storage/' . $user->profile_picture) }}"
                                    alt="">
                            @endif

                            <div class="input-group mt-3">
                                <input type="file" name="profile_picture" id="profilePicture" style="display: none;"
                                    required onchange="displayFileName()">

                                <!-- Custom button to trigger file input -->
                                <button type="button" class="btn btn-sm rounded-2 border border-1 border-dark "
                                    onclick="document.getElementById('profilePicture').click()">
                                    Upload New Picture
                                </button>

                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th>Name: {{ $user->name }}</th>

                    </tr>
                    <tr>
                        <th>Email: {{ $user->email }}</th>
                    </tr>
                    <tr>
                        <th>Role: {{ ucfirst($user->role) }}</th>

                    </tr>

                    <tr>
                        <th>Created At: {{ $user->created_at }}</th>

                    </tr>
            </table>

            <a href="{{ route('users.index') }}" class="btn btn-primary float-start btn-sm float-end m-1">Back</a>
            <button type="submit" class="btn btn-primary btn-sm float-end m-1">Save</button>
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
