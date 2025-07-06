    <div class="modal fade" id="showModal{{ $product->id }}" tabindex="-1" aria-labelledby="showModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex justify-content-center align-items-center">
                        {{-- <img src="{{ asset('assets/img/logostore2.png') }}" alt="" class="navbar-brand"
                            height="30"> --}}
                        <h6 class="mt-4 ms-1 text-black" style="font-weight: 700; font-size: 16px">
                            <span class="text-dark text-uppercase">Product Detail</span>
                        </h6>
                    </div>
                    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row align-items-center">
                        <!-- Product Image Section -->
                        <div class="col-12 col-md-6">
                            @if ($product->picture_url)
                                <div class="form-group text-center">
                                    <img src="{{ Storage::url($product->picture_url) }}" alt="Product Image"
                                        class="img-fluid rounded shadow" style="max-width: 100%; height: auto;">
                                </div>
                            @else
                                <div class="text-center">
                                    <p class="text-muted">No image available</p>
                                </div>
                            @endif
                        </div>

                        <!-- Product Details Section -->
                        <div class="col-12 col-md-6 mt-4 mt-md-0">

                            <h4 class="mb-3">
                                <strong><i class="fa-solid fa-caret-right me-2"></i> Product Name:</strong>
                                <span class="text-muted">{{ $product->name }}</span>
                            </h4>
                            <h4 class="mb-3">
                                <strong><i class="fa-solid fa-tag me-2"></i> Price:</strong>
                                <span class="text-muted">${{ number_format($product->price, 2) }}</span>
                            </h4>
                            <h4 class="mb-3">
                                <strong><i class="fa-solid fa-percent me-2"></i> Discount:</strong>
                                <span class="text-muted">
                                    {{ $product->discount_percentage > 0 ? $product->discount_percentage . '%' : 'No Discount' }}
                                </span>
                            </h4>
                            <h4 class="mb-3">
                                <strong><i class="fa-solid fa-barcode me-2"></i> Barcode:</strong>
                                <span class="text-muted">{{ $product->barcode }}</span>
                            </h4>

                            <h4 class="mb-3">
                                <strong><i class="fa-solid fa-layer-group me-2"></i> Category:</strong>
                                <span class="text-muted">{{ $product->category->name }}</span>
                            </h4>
                            <h4 class="mb-3">
                                <strong><i class="fa-solid fa-boxes-stacked me-2"></i> Stock Quantity:</strong>
                                <span class="text-muted">{{ $product->stock_quantity }}</span>
                            </h4>
                            <h4 class="mb-3">
                                <strong><i class="fa-solid fa-file-lines me-2"></i> Description:</strong>
                                <span class="text-muted">{{ $product->description ?? 'N/A' }}</span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
