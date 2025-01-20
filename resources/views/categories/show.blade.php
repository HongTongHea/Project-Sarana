<div class="modal fade" id="showModal{{ $category->id }}" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog">
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
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="card border-primary">
                            <div class="card-body">
                                <p><strong><i class="fa-solid fa-caret-right"> </i> Category Name:</strong>
                                    {{ $category->name }}</p>
                                <p><strong><i class="fa-solid fa-caret-right"> </i> Description:</strong>
                                    {{ $category->description }}</p>
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
