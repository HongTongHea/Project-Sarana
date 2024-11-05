@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <h3>Edit</h3>
            <div class="">
                <div class="card-body">
                    <form method="post" action="{{route('categories.update', $category->id)}}">
                        @csrf
                        @method('PUT')
                        <div class="row d-flex flex-column">
                            <div class="col-12">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" value="{{ $category->name }}" class="form-control " />
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control">
                                {{ $category->description }}
                                </textarea>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-primary mt-3">Update</button>
                        <a href="{{route('categories.index')}}" class="btn btn-sm btn-danger mt-3">back</a>
                    </form>
                </div>
            </div>
    </div>

@endsection
