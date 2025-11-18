@extends('layouts.app')

@section('title', 'AngkorTech Computer| Contact Messages')

@section('content')
    <div class="container-fluid mt-3">
        <div class="card rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-semibold text-uppercase">Contact Messages</h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="DataTable" class="table mt-3 table-border table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contacts as $contact)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->phone_number ?? 'N/A' }}</td>
                                    <td>{{ Str::limit($contact->message, 50) }}</td>
                                    <td>{{ $contact->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton{{ $contact->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false" title="Actions">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="dropdownMenuButton{{ $contact->id }}">
                                                <!-- View Details -->
                                                <li>
                                                    <button class="dropdown-item d-flex align-items-center"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#showModal{{ $contact->id }}">
                                                        <i class="fa-solid fa-circle-info me-2 text-info"></i>
                                                        View Details
                                                    </button>
                                                </li>

                                                @if (Auth::user()->role === 'admin')
                                                    <!-- Delete - Only visible to admin -->
                                                    <li>
                                                        <button class="dropdown-item d-flex align-items-center"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $contact->id }}">
                                                            <i class="fa-solid fa-trash me-2 text-danger"></i>
                                                            Delete
                                                        </button>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Show Modal -->
                                {{-- @include('contact.show', ['contact' => $contact]) --}}
                                <!-- Delete Modal -->
                                @include('contact.delete', ['contact' => $contact])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
