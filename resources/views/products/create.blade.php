<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-center align-items-center">
                    {{-- <img src="{{ asset('assets/img/logostore2.png') }}" alt="" class="navbar-brand"
                        height="40"> --}}
                    <h6 class="mt-4 ms-1 text-black" style="font-weight: 700; font-size: 16px">
                        AngkorTech <span class="text-black">Computer</span> |
                        <span class="text-dark"> Create Product</span>
                    </h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row">

                                <div class="form-group col-12 col-md-6">
                                    <label for="name" class="form-label">Product Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ old('name') }}" required placeholder="Enter product name">
                                </div>


                                <div class="form-group col-12 col-md-6">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" step="0.01" name="price" class="form-control"
                                        id="price" value="{{ old('price') }}" required placeholder="Enter price">
                                </div>


                                <div class="form-group col-12 col-md-6">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select name="category_id" class="form-select form-control" id="category_id"
                                        required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="stock_quantity" class="form-label">Stock Quantity</label>
                                    <input type="number" name="stock_quantity" class="form-control" id="stock_quantity"
                                        value="{{ old('stock_quantity') }}" required min="0"
                                        placeholder="Enter stock quantity">
                                </div>

                                <div class="form-group col-12 col-md-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" class="form-control" id="description" rows="3">{{ old('description') }}</textarea>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group col-12 col-md-12" style="margin-left: 14px">
                                <label for="picture_url">Product Image:
                                    @if ($errors->has('picture_url'))
                                        <label class="text-danger mt-1">{{ $errors->first('picture_url') }}</label>
                                    @endif
                                </label>

                                <input type="file" class="form-control d-none" name="picture_url" id="picture_url"
                                    accept="image/*" onchange="showPreview(event)"
                                    style="width: 350px; height: 350px; object-fit: cover; border: 1px solid #ccc; border-radius: 5px;">

                                <div id="preview" onclick="triggerFileInput()"
                                    style="cursor: pointer; width: 350px; height: 350px; display: flex; justify-content: center; align-items: center;">

                                    <img id="imagePreview" src="/assets/img/image.png" alt="Image Preview"
                                        class="img-fluid"
                                        style="width: 100%; height: 100%; object-fit: cover; border: 1px solid #ccc; border-radius: 5px;" />
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    function triggerFileInput() {
        document.getElementById('picture_url').click();
    }

    function showPreview(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imagePreview = document.getElementById('imagePreview');
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>
