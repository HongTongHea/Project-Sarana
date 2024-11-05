@extends('layouts.app')
@section('title', 'Management Category List')
@section('content')
<div class="container mt-5">
    <h2>Categories List</h2>
    <a href="{{ route('categories.create') }}" class="btn btn-sm btn-info mb-2">Add New</a>
    <table class="table table-sm table-hover table-bordered" border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle btn-sm" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="">Veiw Detail</a></li>
                                <li>
                                <li><a class="dropdown-item"
                                        href="{{ route('categories.edit',$category->id )}}">Edit</a></li>
                                <li>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item" type="submit">Delete</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
                {{-- <tr>
                    <th colspan="3">
                        No data found.
                    </th>
                </tr>
            @endforelse --}}
        </tbody>
    </table>
</div>

@endsection
