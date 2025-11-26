<div class="modal fade" id="showModal{{ $customer->id }}" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="text-uppercase mt-3 ms-1 text-black" style="font-weight: 700; font-size: 16px">
                        Customer Details
                    </h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="detail-item">
                            <i class="fas fa-user text-primary me-2"></i>
                            <label class="text-muted small mb-1">Name</label>
                            <p class="mb-0 fw-semibold">{{ $customer->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="detail-item">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            <label class="text-muted small mb-1">Email</label>
                            <p class="mb-0 fw-semibold">{{ $customer->email }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="detail-item">
                            <i class="fas fa-phone text-primary me-2"></i>
                            <label class="text-muted small mb-1">Phone</label>
                            <p class="mb-0 fw-semibold">{{ $customer->phone }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="detail-item">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <label class="text-muted small mb-1">Address</label>
                            <p class="mb-0 fw-semibold">{{ $customer->address }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="detail-item">
                            <i class="fas fa-calendar-plus text-primary me-2"></i>
                            <label class="text-muted small mb-1">Created At</label>
                            <p class="mb-0 fw-semibold">{{ $customer->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="detail-item">
                            <i class="fas fa-calendar-check text-primary me-2"></i>
                            <label class="text-muted small mb-1">Updated At</label>
                            <p class="mb-0 fw-semibold">{{ $customer->updated_at->format('d M Y H:i') }}</p>
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
