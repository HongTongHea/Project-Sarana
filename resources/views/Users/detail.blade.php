<div class="modal fade" id="showModal{{ $user->id }}" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h6 class="text-uppercase mt-3 ms-1 text-black" style="font-weight: 700; font-size: 16px">
                    User Details
                </h6>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <!-- Profile Section -->
                <div class="text-center mb-4 pb-4 border-bottom">
                    @if ($user->picture_url)
                        <img src="{{ asset('storage/' . $user->picture_url) }}" alt="{{ $user->name }}"
                            class="rounded-circle shadow-sm object-fit-cover mb-3"
                            style="width: 100px; height: 100px; border: 4px solid #f8f9fa;">
                    @else
                        <div class="rounded-circle shadow-sm d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; font-size: 36px; font-weight: bold; border: 4px solid #f8f9fa;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <h5 class="mb-1 fw-bold">{{ $user->name }}</h5>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    <span
                        class="badge 
                        @if ($user->role == 'admin') bg-danger
                        @elseif($user->role == 'author') bg-warning
                        @else bg-primary @endif px-3 py-2">
                        <i class="fas fa-user-shield me-1"></i>{{ ucfirst($user->role) }}
                    </span>
                </div>

                <!-- Details Grid -->
                <div class="row g-4">
                    <!-- Username -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 h-100" style="background-color: #f8f9fa;">
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 35px; height: 35px; background-color: #667eea;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <span class="text-muted small">Username</span>
                            </div>
                            <p class="mb-0 fw-semibold ms-1">{{ $user->name }}</p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 h-100" style="background-color: #f8f9fa;">
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 35px; height: 35px; background-color: #667eea;">
                                    <i class="fas fa-envelope text-white"></i>
                                </div>
                                <span class="text-muted small">Email Address</span>
                            </div>
                            <p class="mb-0 fw-semibold ms-1 text-break">{{ $user->email }}</p>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 h-100" style="background-color: #f8f9fa;">
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 35px; height: 35px; background-color: #667eea;">
                                    <i class="fas fa-toggle-on text-white"></i>
                                </div>
                                <span class="text-muted small">Account Status</span>
                            </div>
                            <span class="badge bg-success ms-1 px-3 py-2">
                                <i class="fas fa-check-circle me-1"></i>Active
                            </span>
                        </div>
                    </div>

                    <!-- Role -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 h-100" style="background-color: #f8f9fa;">
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 35px; height: 35px; background-color: #667eea;">
                                    <i class="fas fa-user-shield text-white"></i>
                                </div>
                                <span class="text-muted small">User Role</span>
                            </div>
                            <span
                                class="badge 
                                @if ($user->role == 'admin') bg-danger
                                @elseif($user->role == 'author') bg-warning
                                @else bg-primary @endif ms-1 px-3 py-2">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>

                    <!-- Created At -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 h-100" style="background-color: #f8f9fa;">
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 35px; height: 35px; background-color: #667eea;">
                                    <i class="fas fa-calendar-plus text-white"></i>
                                </div>
                                <span class="text-muted small">Created At</span>
                            </div>
                            <p class="mb-0 fw-semibold ms-1">
                                {{ $user->created_at->setTimezone('Asia/Phnom_Penh')->format('M d, Y h:i A') }}
                            </p>
                        </div>
                    </div>

                    <!-- Updated At -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 h-100" style="background-color: #f8f9fa;">
                            <div class="d-flex align-items-center mb-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 35px; height: 35px; background-color: #667eea;">
                                    <i class="fas fa-calendar-check text-white"></i>
                                </div>
                                <span class="text-muted small">Updated At</span>
                            </div>
                            <p class="mb-0 fw-semibold ms-1">
                                {{ $user->updated_at->setTimezone('Asia/Phnom_Penh')->format('M d, Y h:i A') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>

        </div>
    </div>
</div>
