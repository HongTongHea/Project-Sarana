<div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" role="dialog"
    aria-labelledby="deleteModalLabel-{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/logostore2.png') }}" alt="" class="navbar-brand mr-1"
                        height="30">
                    <h6 class="text-uppercase mt-4 ms-1 text-primary    " style="font-weight: 700; font-size: 16px">
                        Clothes
                        <span class="text-warning">Store </span> | <span class="text-dark"> Delete Categories
                        </span>
                        <br>

                    </h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('categories.destroy', $category) }}" method="POST"> @csrf
                @method('DELETE')
                <div class="modal-body text-center">
                    <p class="text-danger">Are you sure you want to delete this categories <strong class="text-dark">
                            {{ $category->name }} </strong> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
