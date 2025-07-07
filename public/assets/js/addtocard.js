document.addEventListener("DOMContentLoaded", function () {
    // Initialize cart from localStorage or create empty array
    let cart = JSON.parse(localStorage.getItem("shoppingCart")) || [];

    // Initialize UI elements
    const addToCartModal = new bootstrap.Modal(
        document.getElementById("addToCartModal")
    );
    const modalProductImg = document.getElementById("modalProductImg");
    const modalProductName = document.getElementById("modalProductName");
    const modalProductPrice = document.getElementById("modalProductPrice");
    const modalProductOriginalPrice = document.getElementById(
        "modalProductOriginalPrice"
    );
    const modalProductDiscount = document.getElementById(
        "modalProductDiscount"
    );
    const modalProductBarcode = document.getElementById("modalProductBarcode");
    const productQty = document.getElementById("productQty");
    const cartItemsContainer = document.querySelector(".cart-items");
    const cartCount = document.querySelector(".cart-count");
    const cartSubtotal = document.querySelector(".cart-subtotal");
    const cartDiscount = document.querySelector(".cart-discount");
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
            discount: parseFloat(this.dataset.discount) || 0,
            img: this.dataset.img,
            stock: parseInt(this.dataset.stock),
            barcode: this.dataset.barcode,
        };

        modalProductImg.src = currentProduct.img;
        modalProductName.textContent = currentProduct.name;
        modalProductBarcode.textContent = currentProduct.barcode
            ? `Barcode: ${currentProduct.barcode}`
            : "";

        // Calculate discounted price
        const discountedPrice =
            currentProduct.discount > 0
                ? currentProduct.price * (1 - currentProduct.discount / 100)
                : currentProduct.price;

        modalProductPrice.textContent = `$${discountedPrice.toFixed(2)}`;

        if (currentProduct.discount > 0) {
            modalProductOriginalPrice.textContent = `$${currentProduct.price.toFixed(
                2
            )}`;
            modalProductDiscount.textContent = `-${currentProduct.discount}%`;
            modalProductOriginalPrice.style.display = "inline";
            modalProductDiscount.style.display = "inline";
        } else {
            modalProductOriginalPrice.style.display = "none";
            modalProductDiscount.style.display = "none";
        }

        productQty.value = 1;

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
    updateCartUI(); // Initialize cart UI with any existing items

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
            const quantity = parseInt(productQty.value);

            if (currentProduct.stock <= 0) {
                alert("This product is out of stock!");
                return;
            }

            if (quantity > currentProduct.stock) {
                alert(`Only ${currentProduct.stock} items available in stock!`);
                return;
            }

            // Check if item already exists in cart
            const existingItemIndex = cart.findIndex(
                (item) => item.id === currentProduct.id
            );

            if (existingItemIndex > -1) {
                // Update quantity if item exists
                cart[existingItemIndex].quantity += quantity;
            } else {
                // Add new item to cart
                const cartItem = {
                    ...currentProduct,
                    quantity,
                };
                cart.push(cartItem);
            }

            // Save to localStorage and update UI
            saveCartToStorage();
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
        let totalDiscount = 0;

        cart.forEach((item, index) => {
            const itemPrice =
                item.discount > 0
                    ? item.price * (1 - item.discount / 100)
                    : item.price;

            subtotal += item.price * item.quantity;
            totalDiscount +=
                item.discount > 0
                    ? ((item.price * item.discount) / 100) * item.quantity
                    : 0;

            const cartItem = document.createElement("div");
            cartItem.className = "cart-item mb-3";
            cartItem.dataset.index = index;

            cartItem.innerHTML = `
                <div class="d-flex align-items-center">
                    <img src="${item.img}" alt="${item.name}" 
                        class="cart-item-img rounded me-3" 
                        style="width: 80px; height: 80px; object-fit: cover;">
                    <div class="cart-item-details flex-grow-1">
                        <p class="mb-1 fw-bold">${item.name}</p>
                        ${
                            item.discount > 0
                                ? `
                            <p class="mb-0">
                                <span class="fw-bold">$${(
                                    itemPrice * item.quantity
                                ).toFixed(2)}</span><br>
                                <span class="text-muted text-decoration-line-through small ms-2">
                                    $${(item.price * item.quantity).toFixed(2)}
                                </span><br>
                                <span class="badge bg-danger ms-2">-${
                                    item.discount
                                }%</span>
                            </p>
                        `
                                : `
                            <p class="mb-0 fw-bold">$${(
                                item.price * item.quantity
                            ).toFixed(2)}</p>
                        `
                        }
                    </div>
                </div>
                   
                <div class="d-flex align-items-center">
                    <button class="btn btn-sm btn-outline-secondary decrease-qty-btn">
                        <i class="fas fa-minus"></i>
                    </button>
                    <span class="mx-2 item-quantity">${item.quantity}</span>
                    <button class="btn btn-sm btn-outline-secondary increase-qty-btn" ${
                        item.quantity >= item.stock ? "disabled" : ""
                    }>
                        <i class="fas fa-plus"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger remove-item-btn ms-4">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;

            cartItemsContainer.appendChild(cartItem);
        });

        cartSubtotal.textContent = `$${subtotal.toFixed(2)}`;
        cartDiscount.textContent = `-$${totalDiscount.toFixed(2)}`;
        cartTotal.textContent = `$${(subtotal - totalDiscount).toFixed(2)}`;
        if (cartCount) {
            cartCount.textContent = cart
                .reduce((sum, item) => sum + item.quantity, 0)
                .toString();
        }

        // Remove items from cart
        document.querySelectorAll(".remove-item-btn").forEach((btn) => {
            btn.addEventListener("click", (e) => {
                const cartItem = e.target.closest(".cart-item");
                const index = parseInt(cartItem.dataset.index);
                if (index > -1) {
                    cart.splice(index, 1);
                    saveCartToStorage();
                    updateCartUI();
                }
            });
        });

        // Increase quantity
        document.querySelectorAll(".increase-qty-btn").forEach((btn) => {
            btn.addEventListener("click", (e) => {
                const cartItem = e.target.closest(".cart-item");
                const index = parseInt(cartItem.dataset.index);
                if (index > -1 && cart[index].quantity < cart[index].stock) {
                    cart[index].quantity++;
                    saveCartToStorage();
                    updateCartUI();
                }
            });
        });

        // Decrease quantity
        document.querySelectorAll(".decrease-qty-btn").forEach((btn) => {
            btn.addEventListener("click", (e) => {
                const cartItem = e.target.closest(".cart-item");
                const index = parseInt(cartItem.dataset.index);
                if (index > -1 && cart[index].quantity > 1) {
                    cart[index].quantity--;
                    saveCartToStorage();
                    updateCartUI();
                }
            });
        });
    }

    // Save cart to localStorage
    function saveCartToStorage() {
        localStorage.setItem("shoppingCart", JSON.stringify(cart));
    }
});
