// product-search.js
document.addEventListener("DOMContentLoaded", function () {
    // Initialize search functionality
    const productSearch = document.getElementById("productSearch");
    const searchButton = document.getElementById("searchButton");
    const productsContainer = document.getElementById("products-container");
    const seeAllBtn = document.getElementById("see-all-btn");
    const productsTitle = document.getElementById("products-title");

    // Store original products and title
    const allOriginalProducts = Array.from(
        document.querySelectorAll(".product-item")
    );
    const originalTitle = productsTitle.textContent;

    function performSearch() {
        const searchTerm = productSearch.value.toLowerCase().trim();

        // Clear previous results
        productsContainer.innerHTML = "";

        if (searchTerm === "") {
            // Show all products if search is empty
            showAllProducts();
            return;
        }

        // Filter products
        const filteredProducts = allOriginalProducts.filter((product) => {
            const productName =
                product
                    .querySelector(".fw-semibold")
                    ?.textContent.toLowerCase() || "";
            const productDesc =
                product
                    .querySelector(".text-muted.small")
                    ?.textContent.toLowerCase() || "";
            const categoryId = product.dataset.categoryId?.toLowerCase() || "";

            return (
                productName.includes(searchTerm) ||
                productDesc.includes(searchTerm) ||
                categoryId.includes(searchTerm)
            );
        });

        if (filteredProducts.length > 0) {
            // Show filtered products
            filteredProducts.forEach((product) => {
                productsContainer.appendChild(product.cloneNode(true));
            });

            // Reinitialize add to cart buttons for new elements
            if (typeof window.reinitializeAddToCartButtons === "function") {
                window.reinitializeAddToCartButtons();
            }
        } else {
            // Show no results message
            showNoResults(searchTerm);
        }
    }

    function showAllProducts() {
        productsContainer.innerHTML = "";
        allOriginalProducts.forEach((product) => {
            productsContainer.appendChild(product.cloneNode(true));
        });
        productsTitle.textContent = originalTitle;

        if (typeof window.reinitializeAddToCartButtons === "function") {
            window.reinitializeAddToCartButtons();
        }
    }

    function showNoResults(searchTerm) {
        productsContainer.innerHTML = `
        <div class="mt-5 pt-5">
            <div class="col-12 text-center py-5 mt-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No products found matching "${searchTerm}"</h5>
            </div>
        </div>
        `;
    }

    // Event listeners
    searchButton.addEventListener("click", performSearch);
    productSearch.addEventListener("keyup", function (e) {
        if (e.key === "Enter") {
            performSearch();
        }
    });

    // Clear search when clicking "See All"
    seeAllBtn.addEventListener("click", function () {
        productSearch.value = "";
        showAllProducts();
    });
});
