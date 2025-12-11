<div class="modal fade" id="showModal{{ $product->id }}" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="text-uppercase mt-3 ms-1 text-black" style="font-weight: 700; font-size: 16px">
                        Product Details
                    </h6>
                </div>
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- Product Information in Grid Layout -->
                <div class="row g-3">
                    <!-- Image Column -->
                    <div class="col-md-4">
                        <div class="card border-0 bg-light-subtle h-100">
                            <div class="card-body d-flex flex-column justify-content-center h-100">
                                @if ($product->picture_url)
                                    <div
                                        class="text-center flex-grow-1 d-flex align-items-center justify-content-center">
                                        <img src="{{ Storage::url($product->picture_url) }}" alt="{{ $product->name }}"
                                            class="img-fluid"
                                            style="max-height: 220px; width: auto; object-fit: contain;">
                                    </div>
                                @else
                                    <div
                                        class="text-center py-5 h-100 d-flex flex-column align-items-center justify-content-center">
                                        <i class="fas fa-image fa-3x text-secondary mb-3"></i>
                                        <p class="text-muted mb-0">No image available</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Left Column - Basic Information -->
                    <div class="col-md-4">
                        <div class="card border-0 bg-light-subtle h-100">
                            <div class="card-body">
                                <h6 class="text-dark mb-3 fw-semibold">
                                    <i class="fas fa-info-circle me-2"></i>Basic Information
                                </h6>

                                <div class="mb-3">
                                    <label class="small text-muted d-block mb-1">Product Name</label>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-tag text-primary me-2"></i>
                                        <span class="fw-medium">{{ $product->name }}</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small text-muted d-block mb-1">Category</label>
                                    <div>
                                        <i class="fas fa-layer-group text-primary me-2"></i>
                                        <span class="fw-medium">{{ $product->category->name }}</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small text-muted d-block mb-1">Barcode</label>
                                    <div>
                                        <i class="fas fa-barcode text-primary me-2"></i>
                                        <span class="fw-medium">{{ $product->barcode }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Pricing & Stock -->
                    <div class="col-md-4">
                        <div class="card border-0 bg-light-subtle h-100">
                            <div class="card-body">
                                <h6 class="text-dark mb-3 fw-semibold">
                                    <i class="fas fa-chart-line me-2"></i>Pricing & Stock
                                </h6>

                                <div class="mb-3">
                                    <label class="small text-muted d-block mb-1">Price</label>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-dollar-sign text-success me-2"></i>
                                        <span class="fw-bold fs-5">${{ number_format($product->price, 2) }}</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small text-muted d-block mb-1">Discount</label>
                                    <div>
                                        <i class="fas fa-percent text-warning me-2"></i>
                                        @if ($product->discount_percentage > 0)
                                            <span class="badge bg-warning text-dark fw-medium">
                                                {{ $product->discount_percentage }}% OFF
                                            </span>
                                        @else
                                            <span class="text-muted fw-medium">No Discount</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small text-muted d-block mb-1">Stock Quantity</label>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-boxes text-info me-2"></i>
                                        <span
                                            class="fw-bold {{ $product->stock_quantity < 10 ? 'text-danger' : 'text-dark' }}">
                                            {{ $product->stock_quantity }}
                                        </span>
                                        @if ($product->stock_quantity < 10)
                                            <span class="badge bg-danger ms-2">Low Stock</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Section -->
                <div class="card border-0 mt-3">
                    <div class="card-body">
                        <h6 class="text-dark mb-3 fw-semibold">
                            <i class="fas fa-align-left me-2"></i>Description
                        </h6>
                        <div class="p-3 bg-light rounded-2">
                            @if ($product->description)
                                <p class="mb-0 text-dark">{{ $product->description }}</p>
                            @else
                                <p class="mb-0 text-muted fst-italic">No description available</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>
