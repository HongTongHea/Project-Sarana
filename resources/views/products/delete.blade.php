<div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <div class="d-flex justify-content-center align-items-center">
                        <h6 class="mt-3 ms-1 text-black text-uppercase" style="font-weight: 700; font-size: 16px">
                            <span class="text-dark text-uppercase"> Delete Product</span>
                        </h6>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="text-danger">Are you sure you want to delete this product <strong class="text-dark">
                            {{ $product->name }} </strong> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>
