<div class="modal fade" id="deleteModal{{ $customer->id }}" tabindex="-1" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="" class="navbar-brand"
                            height="30">
                        <h6 class="text-uppercase mt-3 ms-1 text-primary" style="font-weight: 700; font-size: 15px">
                            Clothes <span class="text-warning">Store </span> |
                            <span class="text-dark"> Delete Customer</span>
                        </h6>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    Are you sure you want to delete {{ $customer->first_name }}
                    {{ $customer->last_name }}?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>
