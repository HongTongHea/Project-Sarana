@extends('layouts.app')

@section('title', 'Customer Details')

@section('content')
    <div class="card rounded-0">
        <div class="card-body">
            <h3>Category Details</h3>

            <div class="card mt-4 rounded-0 w-50 bg-dark text-white">
                <div class="card-header">
                    <h3>Name: {{ $cat->name }}</h3>
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong> {{ $cat->description }}</p>
                    <p><strong>Created At:</strong> {{ $cat->created_at->format('d-m-Y H:i') }}</p>
                    <p><strong>Updated At:</strong> {{ $cat->updated_at->format('d-m-Y H:i') }}</p>

                    <a href="{{ route('categories.edit',$c->id )}}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ url('category') }}" class="btn btn-secondary btn-sm">Back to List</a>

                    <form action="{{ route('category.delete', $c->id) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
