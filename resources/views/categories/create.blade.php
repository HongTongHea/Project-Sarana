<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('categories.store') }}" method="POST"> 
                @csrf 
                <div class="modal-header">
                    <div class="d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="" class="navbar-brand"
                            height="30">
                        <h6 class="text-uppercase mt-3 ms-1 text-primary    " style="font-weight: 700; font-size: 15px">
                            Clothes
                            <span class="text-warning">Store </span> | <span class="text-dark"> Create Categories </span>
                            <br>
                        
                        </h6>
                    </div>
                    <button type="button"class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group"> <label for="name">Name</label> <input type="text"
                            class="form-control" id="name" name="name" required> </div>
                    <div class="form-group"> <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
