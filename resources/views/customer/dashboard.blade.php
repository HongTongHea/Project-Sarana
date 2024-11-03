@extends('layouts.app')

@section('title', 'Customer Dashboard')


@section('content')
    <div class="container mt-2">
        @if (Auth::user()->role === 'admin')
            <h1>Admin Dashboard</h1>
        @elseif(Auth::user()->role === 'customer')
            <h1>Customer Dashboard</h1>
        @else
            <h1>Staff Dashboard</h1>
        @endif
    </div>
@endsection
