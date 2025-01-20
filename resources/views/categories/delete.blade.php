<div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" role="dialog"
    aria-labelledby="deleteModalLabel-{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/logostore2.png') }}" alt="" class="navbar-brand mr-1"
                        height="30">
                    <h6 class="text-uppercase mt-4 ms-1 text-primary    " style="font-weight: 700; font-size: 16px">
                        Clothes
                        <span class="text-warning">Store </span> | <span class="text-dark"> Create Categories
                        </span>
                        <br>

                    </h6>
                </div>
                <button type="button"class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('categories.destroy', $category) }}" method="POST"> @csrf
                @method('DELETE')
                <div class="modal-body text-center">
                    <p>Are you sure you want to delete this categories <strong>
                            {{ $category->name }} </strong> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
