document.addEventListener("DOMContentLoaded", function () {
    // Initialize cart from localStorage
    let cart = JSON.parse(localStorage.getItem("shoppingCart")) || [];

    // Modal and cart UI elements
    const addToCartModal = document.getElementById("addToCartModal")
        ? new bootstrap.Modal(document.getElementById("addToCartModal"))
        : null;
    const modalProductImg = document.getElementById("modalProductImg");
    const modalProductName = document.getElementById("modalProductName");
    const modalProductPrice = document.getElementById("modalProductPrice");
    const modalProductOriginalPrice = document.getElementById(
        "modalProductOriginalPrice"
    );
    const modalProductDiscount = document.getElementById(
        "modalProductDiscount"
    );
    const modalProductDescription = document.getElementById(
        "modalProductDescription"
    );
    const productQty = document.getElementById("productQty");
    const cartItemsContainer = document.querySelector(".cart-items");
    const cartCount = document.querySelector(".cart-count");
    const cartSubtotal = document.querySelector(".cart-subtotal");
    const cartDiscount = document.querySelector(".cart-discount");
    const cartTotal = document.querySelector(".cart-total");
    const cartSummary = document.querySelector(".cart-summary");
    const emptyCartMessage = document.querySelector(".empty-cart-message");
    const stockStatusElement = document.querySelector(".stock-status");

    const productSearch = document.getElementById("productSearch");
    const searchButton = document.getElementById("searchButton");
    const accessoriesContainer = document.getElementById(
        "accessories-container"
    );

    let currentProduct = {};

    // Collect all original accessory items
    const allOriginalAccessories = Array.from(
        document.querySelectorAll(".accessory-item")
    );

    // === SEARCH FUNCTIONALITY (Accessories only) ===
    function performSearch() {
        if (!accessoriesContainer || !productSearch) return;

        const searchTerm = productSearch.value.toLowerCase().trim();
        accessoriesContainer.innerHTML = "";

        if (searchTerm === "") {
            showAllAccessories();
            return;
        }

        const filteredAccessories = allOriginalAccessories.filter(
            (accessory) => {
                const accessoryName =
                    accessory
                        .querySelector(".fw-semibold")
                        ?.textContent.toLowerCase() || "";
                const accessoryDesc =
                    accessory
                        .querySelector(".text-muted.small")
                        ?.textContent.toLowerCase() || "";
                return (
                    accessoryName.includes(searchTerm) ||
                    accessoryDesc.includes(searchTerm)
                );
            }
        );

        if (filteredAccessories.length > 0) {
            filteredAccessories.forEach((accessory) => {
                accessoriesContainer.appendChild(accessory.cloneNode(true));
            });
            reinitializeAddToCartButtons();
        } else {
            showNoResults(searchTerm);
        }
    }

    function showAllAccessories() {
        if (!accessoriesContainer) return;

        accessoriesContainer.innerHTML = "";
        allOriginalAccessories.forEach((accessory) => {
            accessoriesContainer.appendChild(accessory.cloneNode(true));
        });
        reinitializeAddToCartButtons();
    }

    function showNoResults(term) {
        if (!accessoriesContainer) return;

        accessoriesContainer.innerHTML = `
            <div class="mt-5 pt-5">
                <div class="col-12 text-center py-5 mt-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No accessories found matching "${term}"</h5>
                </div>
            </div>
        `;
    }

    // Event Listeners for search
    if (searchButton) {
        searchButton.addEventListener("click", performSearch);
    }

    if (productSearch) {
        productSearch.addEventListener("keyup", function (e) {
            if (e.key === "Enter") {
                performSearch();
            }
        });
    }

    // CART FUNCTIONS
    function reinitializeAddToCartButtons() {
        document.querySelectorAll(".add-to-cart-btn").forEach((btn) => {
            btn.removeEventListener("click", handleAddToCartClick);
            btn.addEventListener("click", handleAddToCartClick);
        });
    }

    function handleAddToCartClick() {
        const cardBody = this.closest(".card-body");
        if (!cardBody) return;

        currentProduct = {
            id: this.dataset.id,
            name: this.dataset.name,
            price: parseFloat(this.dataset.price),
            discount: parseFloat(this.dataset.discount) || 0,
            img: this.dataset.img,
            stock: parseInt(this.dataset.stock),
            description:
                cardBody.querySelector("p.text-muted.small")?.textContent || "",
            barcode: this.dataset.barcode || "",
        };

        if (modalProductImg) modalProductImg.src = currentProduct.img;
        if (modalProductName)
            modalProductName.textContent = currentProduct.name;
        if (modalProductDescription)
            modalProductDescription.textContent = currentProduct.description;

        const discountedPrice = currentProduct.discount
            ? currentProduct.price * (1 - currentProduct.discount / 100)
            : currentProduct.price;

        if (modalProductPrice)
            modalProductPrice.textContent = `$${discountedPrice.toFixed(2)}`;

        if (currentProduct.discount > 0) {
            if (modalProductOriginalPrice) {
                modalProductOriginalPrice.textContent = `$${currentProduct.price.toFixed(
                    2
                )}`;
                modalProductOriginalPrice.style.display = "inline";
            }
            if (modalProductDiscount) {
                modalProductDiscount.textContent = `-${currentProduct.discount}%`;
                modalProductDiscount.style.display = "inline";
            }
        } else {
            if (modalProductOriginalPrice)
                modalProductOriginalPrice.style.display = "none";
            if (modalProductDiscount)
                modalProductDiscount.style.display = "none";
        }

        if (productQty) productQty.value = 1;

        // Stock display
        if (stockStatusElement) {
            stockStatusElement.className = `mb-1 small ${
                currentProduct.stock > 0 ? "text-warning" : "text-danger"
            }`;
            stockStatusElement.innerHTML =
                currentProduct.stock > 0
                    ? '<i class="fas fa-check-circle me-1"></i>In stock'
                    : '<i class="fas fa-times-circle me-1"></i>Out stock';
        }

        if (addToCartModal) addToCartModal.show();
    }

    // Initialize buttons and cart UI
    reinitializeAddToCartButtons();
    updateCartUI();

    // Quantity controls
    const increaseBtn = document.getElementById("increaseQty");
    const decreaseBtn = document.getElementById("decreaseQty");
    const confirmAddBtn = document.getElementById("confirmAddToCart");

    if (increaseBtn && productQty) {
        increaseBtn.addEventListener("click", () => {
            productQty.value = parseInt(productQty.value) + 1;
        });
    }

    if (decreaseBtn && productQty) {
        decreaseBtn.addEventListener("click", () => {
            if (parseInt(productQty.value) > 1) {
                productQty.value = parseInt(productQty.value) - 1;
            }
        });
    }

    if (confirmAddBtn) {
        confirmAddBtn.addEventListener("click", () => {
            const quantity = parseInt(productQty.value);
            if (currentProduct.stock <= 0) {
                alert("This accessory is out of stock!");
                return;
            }
            if (quantity > currentProduct.stock) {
                alert(`Only ${currentProduct.stock} items available in stock!`);
                return;
            }

            const index = cart.findIndex(
                (item) => item.id === currentProduct.id
            );
            if (index > -1) {
                cart[index].quantity += quantity;
            } else {
                cart.push({ ...currentProduct, quantity });
            }

            saveCartToStorage();
            updateCartUI();
            if (addToCartModal) addToCartModal.hide();
        });
    }

    function updateCartUI() {
        if (!cartItemsContainer) return;

        cartItemsContainer.innerHTML = "";

        if (cart.length === 0) {
            if (emptyCartMessage) emptyCartMessage.classList.remove("d-none");
            if (cartSummary) cartSummary.classList.add("d-none");
            if (cartCount) cartCount.textContent = "0";
            return;
        }

        if (emptyCartMessage) emptyCartMessage.classList.add("d-none");
        if (cartSummary) cartSummary.classList.remove("d-none");

        let subtotal = 0,
            discount = 0;

        cart.forEach((item, index) => {
            const itemPrice = item.discount
                ? item.price * (1 - item.discount / 100)
                : item.price;

            subtotal += item.price * item.quantity;
            discount += item.discount
                ? ((item.price * item.discount) / 100) * item.quantity
                : 0;

            const el = document.createElement("div");
            el.className = "cart-item mb-3";
            el.dataset.index = index;

            el.innerHTML = `
                <div class="d-flex align-items-center">
                    <img src="${
                        item.img
                    }" class="cart-item-img rounded me-3" style="width:80px;height:80px;">
                    <div class="cart-item-details flex-grow-1">
                        <p class="mb-1 fw-bold">${item.name}</p>
                        ${
                            item.discount
                                ? `<p class="mb-0">
                                    <span class="fw-bold">$${(
                                        itemPrice * item.quantity
                                    ).toFixed(2)}</span><br>
                                    <span class="text-muted text-decoration-line-through small">$${(
                                        item.price * item.quantity
                                    ).toFixed(2)}</span><br>
                                    <span class="badge bg-danger">-${
                                        item.discount
                                    }%</span>
                                </p>`
                                : `<p class="mb-0 fw-bold">$${(
                                      item.price * item.quantity
                                  ).toFixed(2)}</p>`
                        }
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <button class="btn btn-sm btn-outline-secondary decrease-qty-btn"><i class="fas fa-minus"></i></button>
                    <span class="mx-2 item-quantity">${item.quantity}</span>
                    <button class="btn btn-sm btn-outline-secondary increase-qty-btn" ${
                        item.quantity >= item.stock ? "disabled" : ""
                    }><i class="fas fa-plus"></i></button>
                    <button class="btn btn-sm btn-outline-danger remove-item-btn ms-4"><i class="fas fa-trash"></i></button>
                </div>
            `;

            cartItemsContainer.appendChild(el);
        });

        if (cartSubtotal) cartSubtotal.textContent = `$${subtotal.toFixed(2)}`;
        if (cartDiscount) cartDiscount.textContent = `-$${discount.toFixed(2)}`;
        if (cartTotal)
            cartTotal.textContent = `$${(subtotal - discount).toFixed(2)}`;
        if (cartCount)
            cartCount.textContent = cart.reduce((s, i) => s + i.quantity, 0);

        // Add event listeners to dynamic cart items
        document.querySelectorAll(".remove-item-btn").forEach((btn) => {
            btn.addEventListener("click", function () {
                const index = this.closest(".cart-item").dataset.index;
                cart.splice(index, 1);
                saveCartToStorage();
                updateCartUI();
            });
        });

        document.querySelectorAll(".increase-qty-btn").forEach((btn) => {
            btn.addEventListener("click", function () {
                const index = this.closest(".cart-item").dataset.index;
                if (cart[index].quantity < cart[index].stock) {
                    cart[index].quantity++;
                    saveCartToStorage();
                    updateCartUI();
                }
            });
        });

        document.querySelectorAll(".decrease-qty-btn").forEach((btn) => {
            btn.addEventListener("click", function () {
                const index = this.closest(".cart-item").dataset.index;
                if (cart[index].quantity > 1) {
                    cart[index].quantity--;
                    saveCartToStorage();
                    updateCartUI();
                }
            });
        });
    }

    function saveCartToStorage() {
        localStorage.setItem("shoppingCart", JSON.stringify(cart));
    }
});
