@extends('layouts.app')
@section('title', 'Management Category List')
@section('content')
<div class="container mt-5">
    <div>
        <h2 class="text-center">Add new Category</h2>
    </div>
    <div class="card">

        <div class="card-body">
            <form method="post" action="{{route('categories.store')}}">
                @csrf
                <div class="row d-flex flex-column">
                    <div class="col-12">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control " />
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" width="10%"></textarea>

                    </div>

                </div>
                <button class="btn btn-sm btn-info mt-3">Create</button>
                <a class="btn btn-sm btn-info mt-3" href="{{route('categories.index')}}">Back </a>
            </form>
        </div>
    </div>
</div>


@endsection
