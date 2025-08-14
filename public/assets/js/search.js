// public/js/search.js
class ProductSearch {
    constructor() {
        this.searchInput = document.getElementById("search-input");
        this.searchBtn = document.getElementById("search-btn");
        this.productsContainer = document.getElementById("products-container");
        this.accessoriesContainer = document.getElementById(
            "accessories-container"
        );

        if (this.searchInput && this.searchBtn) {
            this.initEvents();
        }
    }

    initEvents() {
        this.searchBtn.addEventListener("click", () => this.performSearch());
        this.searchInput.addEventListener("keypress", (e) => {
            if (e.key === "Enter") this.performSearch();
        });
    }

    async performSearch() {
        const query = this.searchInput.value.trim();
        if (query.length < 2) {
            alert("Please enter at least 2 characters to search");
            return;
        }

        try {
            const response = await fetch(
                `/search?search=${encodeURIComponent(query)}`
            );
            if (!response.ok) throw new Error("Network response was not ok");

            const data = await response.json();
            this.updateResults(data);
        } catch (error) {
            console.error("Search error:", error);
            alert("An error occurred during search");
        }
    }

    updateResults(data) {
        if (this.productsContainer) {
            this.productsContainer.innerHTML = data.products.length
                ? data.products
                      .map((product) => this.createProductCard(product))
                      .join("")
                : '<div class="col-12 text-center py-4"><p>No products found</p></div>';
        }

        if (this.accessoriesContainer) {
            this.accessoriesContainer.innerHTML = data.accessories.length
                ? data.accessories
                      .map((accessory) => this.createAccessoryCard(accessory))
                      .join("")
                : '<div class="col-12 text-center py-4"><p>No accessories found</p></div>';
        }
    }

    createProductCard(product) {
        const discountedPrice =
            product.discount_percentage > 0
                ? product.price * (1 - product.discount_percentage / 100)
                : product.price;

        return `
            <div class="col-6 col-sm-4 col-md-3 col-lg-2-4 mb-4 product-item" data-category-id="${
                product.category_id
            }">
                <div class="card border-0 position-relative product-card">
                    ${
                        product.discount_percentage > 0
                            ? `<span class="badge bg-danger position-absolute top-0 start-0 m-2 z-3">-${product.discount_percentage}%</span>`
                            : ""
                    }
                    <div class="overflow-hidden product-image-container position-relative">
                        <img src="{{ asset('storage/') }}/${
                            product.picture_url
                        }" alt="${product.name}"
                            class="card-img-top img-fluid product-image mt-2">
                        <button class="btn btn-sm position-absolute top-5 end-0 m-2 border-0 bg-white rounded-circle shadow-sm"
                            style="margin-top: 8rem !important;">
                            <i class="far fa-heart text-dark"></i>
                        </button>
                    </div>
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            ${
                                product.discount_percentage > 0
                                    ? `<span class="text-danger fw-bold me-1">$${discountedPrice.toFixed(
                                          2
                                      )}</span>
                                 <span class="text-muted text-decoration-line-through small">$${product.price.toFixed(
                                     2
                                 )}</span>`
                                    : `<span class="text-dark fw-bold">$${product.price.toFixed(
                                          2
                                      )}</span>`
                            }
                        </div>
                        <p class="mb-1 small ${
                            product.stock_quantity > 0
                                ? "text-warning"
                                : "text-danger"
                        }">
                            ${
                                product.stock_quantity > 0
                                    ? '<i class="fas fa-check-circle me-1"></i>In stock'
                                    : '<i class="fas fa-times-circle me-1"></i>Out stock'
                            }
                        </p>
                        <div class="d-flex flex-column">
                            <p class="mb-1 fw-semibold">${product.name}</p>
                            <p class="mb-0 text-muted small">${
                                product.description
                            }</p>
                        </div>
                        <button class="btn btn-outline-primary btn-sm mt-2 w-100 add-to-cart-btn"
                            data-id="${product.id}" data-name="${product.name}"
                            data-price="${product.price}" data-discount="${
            product.discount_percentage
        }"
                            data-img="{{ asset('storage/') }}/${
                                product.picture_url
                            }"
                            data-stock="${
                                product.stock_quantity
                            }" data-barcode="${product.barcode}">
                            <i class="fas fa-shopping-cart me-1"></i>
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    createAccessoryCard(accessory) {
        const discountedPrice =
            accessory.discount_percentage > 0
                ? accessory.price * (1 - accessory.discount_percentage / 100)
                : accessory.price;

        return `
            <div class="col-6 col-sm-4 col-md-3 col-lg-2-4 mb-4 accessory-item">
                <div class="card border-0 position-relative product-card">
                    ${
                        accessory.discount_percentage > 0
                            ? `<span class="badge bg-danger position-absolute top-0 start-0 m-2 z-3">-${accessory.discount_percentage}%</span>`
                            : ""
                    }
                    <div class="overflow-hidden product-image-container position-relative">
                        <img src="{{ asset('storage/') }}/${
                            accessory.picture_url
                        }" alt="${accessory.name}"
                            class="card-img-top img-fluid product-image mt-2">
                        <button class="btn btn-sm position-absolute top-5 end-0 m-2 border-0 bg-white rounded-circle shadow-sm"
                            style="margin-top: 8rem !important;">
                            <i class="far fa-heart text-dark"></i>
                        </button>
                    </div>
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            ${
                                accessory.discount_percentage > 0
                                    ? `<span class="text-danger fw-bold me-1">$${discountedPrice.toFixed(
                                          2
                                      )}</span>
                                 <span class="text-muted text-decoration-line-through small">$${accessory.price.toFixed(
                                     2
                                 )}</span>`
                                    : `<span class="text-dark fw-bold">$${accessory.price.toFixed(
                                          2
                                      )}</span>`
                            }
                        </div>
                        <p class="mb-1 small ${
                            accessory.stock_quantity > 0
                                ? "text-warning"
                                : "text-danger"
                        }">
                            ${
                                accessory.stock_quantity > 0
                                    ? '<i class="fas fa-check-circle me-1"></i>In stock'
                                    : '<i class="fas fa-times-circle me-1"></i>Out stock'
                            }
                        </p>
                        <div class="d-flex flex-column">
                            <p class="mb-1 fw-semibold">${accessory.name}</p>
                            <p class="mb-0 text-muted small">${
                                accessory.description
                            }</p>
                        </div>
                        <button class="btn btn-outline-primary btn-sm mt-2 w-100 add-to-cart-btn"
                            data-id="${accessory.id}" data-name="${
            accessory.name
        }"
                            data-price="${accessory.price}" data-discount="${
            accessory.discount_percentage
        }"
                            data-img="{{ asset('storage/') }}/${
                                accessory.picture_url
                            }"
                            data-stock="${
                                accessory.stock_quantity
                            }" data-barcode="${accessory.barcode}">
                            <i class="fas fa-shopping-cart me-1"></i>
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        `;
    }
}

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
    if (document.getElementById("search-input")) {
        new ProductSearch();
    }
});
