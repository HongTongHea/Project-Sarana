<div class="modal fade" id="showModal{{ $user->id }}" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="text-uppercase mt-3 ms-1 text-black" style="font-weight: 700; font-size: 16px">
                        User Details
                    </h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <div class="row">

                    <!-- Profile -->
                    <div class="col-md-6 mb-3">
                        <div class="detail-item d-flex align-items-center">
                            <i class="fas fa-user-circle text-primary me-2"></i>
                            <label class="text-muted small mb-1">Profile</label>
                        </div>
                        @if ($user->picture_url)
                            <img src="{{ asset('storage/' . $user->picture_url) }}" alt="{{ $user->name }}"
                                class="avatar-img avatar-lg rounded-5 object-fit-cover object-center" width="80">
                        @else
                            <div class="avatar-img rounded-5 d-flex align-items-center justify-content-center bg-secondary"
                                style="width: 50px; height: 50px;color: #fff; font-size: 20px; font-weight: bold;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <div class="detail-item">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            <label class="text-muted small mb-1">Email</label>
                            <p class="mb-0 fw-semibold">{{ $user->email }}</p>
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="col-md-6 mb-3">
                        <div class="detail-item">
                            <i class="fas fa-user text-primary me-2"></i>
                            <label class="text-muted small mb-1">Username</label>
                            <p class="mb-0 fw-semibold">{{ $user->name }}</p>
                        </div>
                    </div>





                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <div class="detail-item">
                            <i class="fas fa-toggle-on text-primary me-2"></i>
                            <label class="text-muted small mb-1">Status</label>
                            <p class="mb-0 fw-semibold">
                                <span class="badge bg-success">Active</span>
                            </p>
                        </div>
                    </div>

                    <!-- Role -->
                    <div class="col-md-6 mb-3">
                        <div class="detail-item">
                            <i class="fas fa-user-shield text-primary me-2"></i>
                            <label class="text-muted small mb-1">Role</label> <br>
                            <span
                                class="badge 
                                            @if ($user->role == 'admin') bg-danger
                                            @elseif($user->role == 'author') bg-warning
                                            @else bg-primary @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="detail-item">
                            <i class="fas fa-calendar-plus text-primary me-2"></i>
                            <label class="text-muted small mb-1">Created At</label>
                            <p class="mb-0 fw-semibold">
                                {{ $user->created_at->setTimezone('Asia/Phnom_Penh')->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="detail-item">
                            <i class="fas fa-calendar-check text-primary me-2"></i>
                            <label class="text-muted small mb-1">Updated At</label>
                            <p class="mb-0 fw-semibold">
                                {{ $user->updated_at->setTimezone('Asia/Phnom_Penh')->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Close
                </button>
            </div>

        </div>
    </div>
</div>
