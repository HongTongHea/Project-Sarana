<div class="modal fade" id="deleteModal{{ $contact->id }}" tabindex="-1"
    aria-labelledby="deleteModalLabel{{ $contact->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('contact.destroy', $contact->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">

                <div class="modal-header">
                    <div class="d-flex justify-content-center align-items-center">
                        <h6 class="mt-3 ms-1 text-black text-uppercase" style="font-weight: 700; font-size: 16px">
                            Delete Contact Message
                        </h6>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this contact message from <strong>{{ $contact->name }}</strong>?
                    </p>
                    {{-- <p class="text-muted">This action cannot be undone.</p> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i
                            class="fas fa-times me-1"></i>Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm"> <i
                            class="fa-solid fa-trash me-1"></i>Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>
