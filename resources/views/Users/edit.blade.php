@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="card rounded-0">
            <div class="card-body">
                <h1>Edit User</h1>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12 col-md-6 form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label for="password">Password (leave blank to keep current password)</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <div class="col-12 col-md-6 form-group">
                            <label for="profile_picture">Profile Picture</label>
                            <input type="file" name="profile_picture" class="form-control">
                        </div>

                        <div class="col-12 col-md-6 form-group mt-2 ">
                            @if ($user->profile_picture)
                                <p>Current Profile Picture:</p>
                                <img src="{{ Storage::url($user->profile_picture) }}" alt="Profile Picture"
                                    class="img-thumbnail" width="150">
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Cancel</a>
                </form>
            </div>
        </div>
    </div>

@endsection
