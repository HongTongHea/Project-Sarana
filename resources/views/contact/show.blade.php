<!-- Contact Details Modal -->
<div class="modal fade" id="showModal{{ $contact->id }}" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h6 class="text-uppercase mt-3 ms-1 text-black" style="font-weight: 700; font-size: 16px">
                    Contact Message Details
                </h6>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <!-- Profile Section -->
                <div class="text-center mb-4 pb-4 border-bottom">
                    <div class="rounded-circle shadow-sm d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 100px; height: 100px; background-color: #667eea;">
                        <span style="color: white; font-size: 36px; font-weight: bold;">
                            {{ strtoupper(substr($contact->name, 0, 1)) }}
                        </span>
                    </div>
                    <h5 class="mb-1 fw-bold">{{ $contact->name }}</h5>
                    <p class="text-muted mb-2">{{ $contact->email }}</p>
                    @if ($contact->read_status)
                        <span class="badge bg-success px-3 py-2">
                            <i class="fas fa-check-circle me-1"></i>Read
                        </span>
                    @else
                        <span class="badge bg-warning text-dark px-3 py-2">
                            <i class="fas fa-envelope me-1"></i>Unread
                        </span>
                    @endif
                </div>

                <!-- Details Grid -->
                <div class="row g-4">
                    <!-- Name -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background-color: #f8f9fa;">
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 35px; height: 35px; background-color: #667eea;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <span class="text-muted small">Full Name</span>
                            </div>
                            <p class="mb-0 fw-semibold ms-1">{{ $contact->name }}</p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background-color: #f8f9fa;">
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 35px; height: 35px; background-color: #667eea;">
                                    <i class="fas fa-envelope text-white"></i>
                                </div>
                                <span class="text-muted small">Email Address</span>
                            </div>
                            <p class="mb-0 fw-semibold ms-1">{{ $contact->email }}</p>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background-color: #f8f9fa;">
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 35px; height: 35px; background-color: #667eea;">
                                    <i class="fas fa-phone text-white"></i>
                                </div>
                                <span class="text-muted small">Phone Number</span>
                            </div>
                            <p class="mb-0 fw-semibold ms-1">{{ $contact->phone_number ?? 'Not provided' }}</p>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background-color: #f8f9fa;">
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 35px; height: 35px; background-color: #667eea;">
                                    <i class="fas fa-calendar-alt text-white"></i>
                                </div>
                                <span class="text-muted small">Submitted Date</span>
                            </div>
                            <p class="mb-0 fw-semibold ms-1">
                                {{ $contact->created_at->format('M d, Y h:i A') }}
                            </p>
                        </div>
                    </div>

                    <!-- Message -->
                    <div class="col-12">
                        <div class="p-3 rounded-3" style="background-color: #f8f9fa;">
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 35px; height: 35px; background-color: #667eea;">
                                    <i class="fas fa-comment text-white"></i>
                                </div>
                                <span class="text-muted small">Message</span>
                            </div>
                            <div class="ms-1 mt-2 p-3 bg-white rounded-3 border">
                                <p class="mb-0">
                                    {{ $contact->message }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 bg-light">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div>
                        @if (!$contact->read_status)
                            <!-- Mark as Read Form (only shows if unread) -->
                            <form action="{{ route('contact.mark-as-read', $contact->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-check-circle me-2"></i>Mark as Read
                                </button>
                            </form>
                        @else
                            <!-- Read Already Badge (shows if already read) -->
                            <span class="badge bg-success px-3 py-2">
                                <i class="fas fa-check-circle me-1"></i>Read Already
                            </span>
                        @endif
                    </div>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Close
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
