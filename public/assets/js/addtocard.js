document.addEventListener("DOMContentLoaded", function () {
    // Initialize cart and UI elements
    const cart = [];
    const addToCartModal = new bootstrap.Modal(
        document.getElementById("addToCartModal")
    );
    const modalProductImg = document.getElementById("modalProductImg");
    const modalProductName = document.getElementById("modalProductName");
    const modalProductPrice = document.getElementById("modalProductPrice");
    const productSize = document.getElementById("productSize");
    const productQty = document.getElementById("productQty");
    const cartItemsContainer = document.querySelector(".cart-items");
    const cartCount = document.querySelector(".cart-count");
    const cartSubtotal = document.querySelector(".cart-subtotal");
    const cartTotal = document.querySelector(".cart-total");
    const cartSummary = document.querySelector(".cart-summary");
    const emptyCartMessage = document.querySelector(".empty-cart-message");
    const stockStatusElement = document.querySelector(".stock-status");
    const seeAllBtn = document.getElementById("see-all-btn");

    let currentProduct = {};

    // Store original product DOM elements and title
    const allOriginalProducts = Array.from(
        document.querySelectorAll(".product-item")
    );
    const originalTitle = document.getElementById("products-title").textContent;

    // Category filtering
    const categoryItems = document.querySelectorAll(".category-item");
    categoryItems.forEach((category) => {
        category.addEventListener("click", function () {
            const categoryId = this.getAttribute("data-category-id");
            const categoryName = this.querySelector(".card-title").textContent;

            // Filter original product list in memory
            const filteredProducts = allOriginalProducts.filter(
                (product) =>
                    product.getAttribute("data-category-id") === categoryId
            );

            const productsContainer =
                document.getElementById("products-container");
            productsContainer.innerHTML = "";

            if (filteredProducts.length > 0) {
                filteredProducts.forEach((product) => {
                    productsContainer.appendChild(product.cloneNode(true));
                });
            } else {
                productsContainer.innerHTML = `
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No products found in this category</h5>
                        </div>
                    `;
            }

            document.getElementById(
                "products-title"
            ).textContent = `${categoryName} Products`;

            // Reinitialize add-to-cart buttons
            reinitializeAddToCartButtons();
        });
    });

    // See All button
    seeAllBtn.addEventListener("click", function () {
        const productsContainer = document.getElementById("products-container");
        productsContainer.innerHTML = "";
        allOriginalProducts.forEach((product) => {
            productsContainer.appendChild(product.cloneNode(true));
        });
        document.getElementById("products-title").textContent = originalTitle;
        reinitializeAddToCartButtons();
    });

    // Reinitialize add to cart buttons
    function reinitializeAddToCartButtons() {
        document.querySelectorAll(".add-to-cart-btn").forEach((button) => {
            button.removeEventListener("click", handleAddToCartClick);
            button.addEventListener("click", handleAddToCartClick);
        });
    }

    function handleAddToCartClick() {
        currentProduct = {
            id: this.dataset.id,
            name: this.dataset.name,
            price: parseFloat(this.dataset.price),
            img: this.dataset.img,
            stock: parseInt(this.dataset.stock),
        };

        modalProductImg.src = currentProduct.img;
        modalProductName.textContent = currentProduct.name;
        modalProductPrice.textContent = `$${currentProduct.price.toFixed(2)}`;
        productQty.value = 1;
        productSize.value = "M";

        // Stock status
        if (currentProduct.stock > 0) {
            stockStatusElement.className = "mb-1 small text-warning";
            stockStatusElement.innerHTML =
                '<i class="fas fa-check-circle me-1"></i>In stock';
        } else {
            stockStatusElement.className = "mb-1 small text-danger";
            stockStatusElement.innerHTML =
                '<i class="fas fa-times-circle me-1"></i>Out of stock';
        }

        addToCartModal.show();
    }

    // Init add-to-cart buttons on load
    reinitializeAddToCartButtons();

    // Quantity controls
    document.getElementById("increaseQty").addEventListener("click", () => {
        productQty.value = parseInt(productQty.value) + 1;
    });

    document.getElementById("decreaseQty").addEventListener("click", () => {
        if (parseInt(productQty.value) > 1) {
            productQty.value = parseInt(productQty.value) - 1;
        }
    });

    // Confirm add to cart
    document
        .getElementById("confirmAddToCart")
        .addEventListener("click", () => {
            const size = productSize.value;
            const quantity = parseInt(productQty.value);

            if (currentProduct.stock <= 0) {
                alert("This product is out of stock!");
                return;
            }

            if (quantity > currentProduct.stock) {
                alert(`Only ${currentProduct.stock} items available in stock!`);
                return;
            }

            const cartItem = {
                ...currentProduct,
                size,
                quantity,
            };

            cart.push(cartItem);
            updateCartUI();
            addToCartModal.hide();
        });

    // Update cart UI
    function updateCartUI() {
        cartItemsContainer.innerHTML = "";

        if (cart.length === 0) {
            emptyCartMessage.classList.remove("d-none");
            cartSummary.classList.add("d-none");
            if (cartCount) cartCount.textContent = "0";
            return;
        }

        emptyCartMessage.classList.add("d-none");
        cartSummary.classList.remove("d-none");

        let subtotal = 0;

        cart.forEach((item) => {
            subtotal += item.price * item.quantity;

            const cartItem = document.createElement("div");
            cartItem.className = "cart-item d-flex align-items-center mb-3";

            cartItem.innerHTML = `
                    <img src="${item.img}" alt="${
                item.name
            }" class="cart-item-img rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
                    <div class="cart-item-details flex-grow-1">
                        <p class="mb-1 fw-bold">${item.name}</p>
                        <p class="mb-0 small text-muted">Size: ${
                            item.size
                        } | Qty: ${item.quantity}</p>
                        <p class="mb-0 small">$${(
                            item.price * item.quantity
                        ).toFixed(2)}</p>
                    </div>
                    <button class="btn btn-sm btn-outline-danger remove-item-btn" data-id="${
                        item.id
                    }">
                        <i class="fas fa-trash"></i>
                    </button>
                `;

            cartItemsContainer.appendChild(cartItem);
        });

        cartSubtotal.textContent = `$${subtotal.toFixed(2)}`;
        cartTotal.textContent = `$${subtotal.toFixed(2)}`;
        if (cartCount) cartCount.textContent = cart.length.toString();

        // Remove items from cart
        document.querySelectorAll(".remove-item-btn").forEach((btn) => {
            btn.addEventListener("click", () => {
                const idToRemove = btn.dataset.id;
                const index = cart.findIndex((item) => item.id === idToRemove);
                if (index > -1) {
                    cart.splice(index, 1);
                    updateCartUI();
                }
            });
        });
    }
});
