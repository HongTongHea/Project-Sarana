<div class="modal fade" id="showModal{{ $customer->id }}" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="mt-3 ms-1 text-black text-uppercase" style="font-weight: 700; font-size: 16px">
                        Customer Details
                    </h6>
                </div>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong><i class="fa-solid fa-caret-right"> </i> Name:</strong> {{ $customer->name }}</p>
                <p><strong><i class="fa-solid fa-caret-right"> </i> Email:</strong> {{ $customer->email }}</p>
                <p><strong><i class="fa-solid fa-caret-right"> </i> Phone:</strong> {{ $customer->phone }}</p>
                <p><strong><i class="fa-solid fa-caret-right"> </i> Address:</strong> {{ $customer->address }}</p>
                <p><strong><i class="fa-solid fa-caret-right"> </i> Created At:</strong>
                    {{ $customer->created_at->format('d M Y H:i') }}</p>
                <p><strong><i class="fa-solid fa-caret-right"> </i> Updated At:</strong>
                    {{ $customer->updated_at->format('d M Y H:i') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
