@extends('layouts.app')

@section('title', 'User Details')

@section('content')
    <div class="card rounded-0 shadow ">
        <div class="card-body">
            <h1>User Details</h1>
            <div class="border p-3">
                <form action="{{ route('profile.picture.update') }}" method="POST" enctype="multipart/form-data"
                    class="d-flex flex-column p-2">
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
    </div>


    <script>
        function displayFileName() {
            const fileInput = document.getElementById('profilePicture');
            const fileNameDisplay = document.getElementById('fileName');
            fileNameDisplay.textContent = fileInput.files[0] ? fileInput.files[0].name : 'No file chosen';
        }
    </script>
@endsection
