@extends('layouts.app')

@section('content')
    @if (in_array(Auth::user()->role, ['admin', 'manager', 'cashier']))
        <h1>Dashboard</h1>
        {{-- Shared content for admin/manager/cashier --}}
        <p>Welcome, {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})</p>
    @else
        <h1>Unauthorized</h1>
    @endif
@endsection
