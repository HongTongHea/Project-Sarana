<div class="modal fade" id="editModal{{ $accessory->id }}" tabindex="-1" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="mt-3 ms-1 text-black text-uppercase" style="font-weight: 700; font-size: 16px">
                        <span class="text-dark"> Edit Accessory</span>
                    </h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('accessories.update', $accessory->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-12 col-md-8">
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="name" class="form-label">Accessory Name</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ old('name', $accessory->name) }}" required
                                        placeholder="Enter accessory name">
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="brand" class="form-label">Brand Name</label>
                                    <input type="text" name="brand" class="form-control" id="brand"
                                        value="{{ old('brand', $accessory->brand) }}" required
                                        placeholder="Enter brand name">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" step="0.01" name="price" class="form-control"
                                        id="price" value="{{ old('price', $accessory->price) }}" required
                                        placeholder="Enter price">
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <label for="discount_percentage" class="form-label">Discount %</label>
                                    <input type="number" step="0.01" name="discount_percentage" class="form-control"
                                        id="discount_percentage"
                                        value="{{ old('discount_percentage', $accessory->discount_percentage) }}"
                                        min="0" max="100" placeholder="Enter discount percentage">
                                </div>

                                <div class="form-group col-12 col-md-12">
                                    <label for="stock_quantity" class="form-label">Stock Quantity</label>
                                    <input type="number" name="stock_quantity" class="form-control" id="stock_quantity"
                                        value="{{ old('stock_quantity', $accessory->stock_quantity) }}" required
                                        min="0" placeholder="Enter stock quantity">
                                </div>

                                <div class="form-group col-12 col-md-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" class="form-control" id="description" rows="3">{{ old('description', $accessory->description) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4 p-0 mt-md-0 mt-3">
                            <div class="form-group">
                                <label for="picture_url">Accessory Image:</label>
                                @if ($errors->has('picture_url'))
                                    <label class="text-danger mt-1">{{ $errors->first('picture_url') }}</label>
                                @endif

                                <!-- File input for image upload -->
                                <input type="file" class="form-control d-none" name="picture_url"
                                    id="edit_picture_url_{{ $accessory->id }}" accept="image/*"
                                    onchange="showEditPreview(event, {{ $accessory->id }})">

                                <!-- Image preview container -->
                                <div id="edit_preview_{{ $accessory->id }}"
                                    onclick="triggerEditFileInput({{ $accessory->id }})"
                                    style="cursor: pointer; width: 350px; height: 350px; display: flex; justify-content: center; align-items: center; border: 1px solid #ccc; border-radius: 5px;">
                                    <img id="edit_imagePreview_{{ $accessory->id }}"
                                        src="{{ $accessory->picture_url ? asset('storage/' . $accessory->picture_url) : '/assets/img/image.png' }}"
                                        alt="Image Preview" class="img-fluid"
                                        style="width: 100%; height: 100%; object-fit: cover;" />
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

<script>
    // Function to show the image preview when a file is selected
    function showEditPreview(event, accessoryId) {
        const fileInput = event.target;
        const previewImage = document.getElementById(`edit_imagePreview_${accessoryId}`);

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result; // Update preview with the selected image
            };
            reader.readAsDataURL(fileInput.files[0]); // Read the file as a Data URL
        }
    }

    // Function to trigger the file input click when the preview is clicked
    function triggerEditFileInput(accessoryId) {
        const fileInput = document.getElementById(`edit_picture_url_${accessoryId}`);
        fileInput.click(); // Trigger the file input dialog
    }
</script>
