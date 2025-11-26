<div class="modal fade" id="deleteModal{{ $supplier->id }}" tabindex="-1" role="dialog"
    aria-labelledby="deleteModalLabel-{{ $supplier->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="mt-3 ms-1 text-black text-uppercase" style="font-weight: 700; font-size: 16px">
                        Delete Supplier
                    </h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center">
                    <p class="text-danger">Are you sure you want to delete this supplier <strong class="text-dark">
                            {{ $supplier->name }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-danger btn-sm"><i
                            class="fa-solid fa-trash me-1"></i>Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
