<div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel-{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="mt-3 ms-1 text-black text-uppercase" style="font-weight: 700; font-size: 16px">
                        Edit Category
                    </h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('categories.update', $category) }}" method="POST"> @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group"> <label for="name">Name</label> <input type="text"
                            class="form-control" id="name" name="name" value="{{ $category->name }}" required>
                    </div>
                    <div class="form-group"> <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description">{{ $category->description }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                            class="fas fa-times me-1"></i>Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm"><i
                            class="fa-solid fa-floppy-disk me-1"></i>Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
