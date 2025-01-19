<div class="modal fade" id="showModal{{ $customer->id }}" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="" class="navbar-brand" height="30">
                    <h6 class="text-uppercase mt-3 ms-1 text-primary" style="font-weight: 700; font-size: 15px">
                        Clothes <span class="text-warning">Store </span> |
                        <span class="text-dark">Customer Detail</span>
                    </h6>
                </div>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title"><i class="bi bi-person"></i> Personal Information</h6>
                                <p><strong><i class="fa-solid fa-caret-right"> </i> First Name:</strong> {{ $customer->first_name }}</p>
                                <p><strong><i class="fa-solid fa-caret-right"> </i> Last Name:</strong> {{ $customer->last_name }}</p>
                                <p><strong><i class="fa-solid fa-caret-right"> </i> Gender:</strong> {{ $customer->gender }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title"><i class="bi bi-envelope"></i> Contact Information</h6>
                                <p><strong><i class="fa-solid fa-caret-right"> </i> Email:</strong> {{ $customer->email }}</p>
                                <p><strong><i class="fa-solid fa-caret-right"> </i> Phone:</strong> {{ $customer->phone }}</p>
                                <p><strong><i class="fa-solid fa-caret-right"> </i> Address:</strong> {{ $customer->address }}</p>
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
