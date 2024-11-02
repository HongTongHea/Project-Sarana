@extends('layouts.app')

@section('content')
    @if (Auth::user()->role === 'admin')
        <h1>Admin Dashboard</h1>
    @elseif(Auth::user()->role === 'customer')
        <h1>Customer Dashboard</h1>
    @else
        <h1>Staff Dashboard</h1>
    @endif
@endsection
