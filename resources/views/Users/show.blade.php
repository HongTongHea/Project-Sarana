@extends('layouts.app')

@section('content')

            <div class="card rounded-0 shadow ">
                <div class="card-body">
                    <h1>User Details</h1>
                    <table class="table">
                      
                        <tr>
                            <th>
                                @if ($user->profile_picture)
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}"
                                        class="avatar-img avatar-lg  rounded-5 opject-fit-cover object-center " width="100%">
                                @else
                                    No picture available
                                @endif
                            </th>
                        </tr>
     
                        <tr>
                            <th>ID: {{ $user->id }}</th>
    
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
    
                    <a href="{{ route('users.index') }}" class="btn btn-primary float-start btn-sm">Back</a>
                </div>
            </div>
@endsection
