<div class="modal fade" id="showModal{{ $customer->id }}" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/logostore2.png') }}" alt="" class="navbar-brand" height="30">
                    <h6 class="text-uppercase mt-4 ms-1 text-primary" style="font-weight: 700; font-size: 16px">
                        Clothes <span class="text-warning">Store </span> |
                        <span class="text-dark">Customer Detail</span>
                    </h6>
                </div>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Personal Information Section -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 ">
                            <div class="card-header">
                                <h6 class="card-title mb-0"><i class="bi bi-person-fill"></i> Personal Information</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-3">
                                    <strong><i class="fa-solid fa-user me-2"></i> First Name:</strong>
                                    <span class="text-muted">{{ $customer->first_name }}</span>
                                </p>
                                <p class="mb-3">
                                    <strong><i class="fa-solid fa-user me-2"></i> Last Name:</strong>
                                    <span class="text-muted">{{ $customer->last_name }}</span>
                                </p>
                                <p class="mb-3">
                                    <strong><i class="fa-solid fa-venus-mars me-2"></i> Gender:</strong>
                                    <span class="text-muted">{{ $customer->gender }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
            
                    <!-- Contact Information Section -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h6 class="card-title mb-0"><i class="bi bi-envelope-fill"></i> Contact Information</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-3">
                                    <strong><i class="fa-solid fa-envelope me-2"></i> Email:</strong>
                                    <span class="text-muted">{{ $customer->email }}</span>
                                </p>
                                <p class="mb-3">
                                    <strong><i class="fa-solid fa-phone me-2"></i> Phone:</strong>
                                    <span class="text-muted">{{ $customer->phone }}</span>
                                </p>
                                <p class="mb-3">
                                    <strong><i class="fa-solid fa-location-dot me-2"></i> Address:</strong>
                                    <span class="text-muted">{{ $customer->address }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
