$(document).ready(function () {
    let cart = JSON.parse(localStorage.getItem("shoppingCart")) || [];

    // Modal & UI elements
    const addToCartModal = $("#addToCartModal").length
        ? new bootstrap.Modal($("#addToCartModal")[0])
        : null;
    const modalProductImg = $("#modalProductImg");
    const modalProductName = $("#modalProductName");
    const modalProductPrice = $("#modalProductPrice");
    const modalProductOriginalPrice = $("#modalProductOriginalPrice");
    const modalProductDiscount = $("#modalProductDiscount");
    const modalProductDescription = $("#modalProductDescription");
    const productQty = $("#productQty");
    const cartItemsContainer = $(".cart-items");
    const cartCount = $(".cart-count");
    const cartSubtotal = $(".cart-subtotal");
    const cartDiscount = $(".cart-discount");
    const cartTotal = $(".cart-total");
    const cartSummary = $(".cart-summary");
    const emptyCartMessage = $(".empty-cart-message");
    const stockStatusElement = $(".stock-status");

    let currentProduct = {};

    // ✅ Toast function
    function showCartToast(message, type = "success") {
        const toastContainer = $("#cartToastContainer");
        if (!toastContainer.length) return;

        const toast = $(`
            <div class="toast align-items-center text-bg-${type} border-0 show mb-2" role="alert">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `);

        toastContainer.append(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    // Add to cart button logic
    function reinitializeAddToCartButtons() {
        $(".add-to-cart-btn").off("click").on("click", handleAddToCartClick);
    }

    function handleAddToCartClick() {
        const cardBody = $(this).closest(".card-body");
        if (!cardBody.length) return;

        currentProduct = {
            id: $(this).data("id"),
            name: $(this).data("name"),
            price: parseFloat($(this).data("price")),
            discount: parseFloat($(this).data("discount")) || 0,
            img: $(this).data("img"),
            stock: parseInt($(this).data("stock")),
            description: $(this).data("description") || "",
            barcode: $(this).data("barcode") || "",
            type: $(this).closest('.accessory-item').length ? 'accessory' : 'product'
        };

        modalProductImg.attr("src", currentProduct.img);
        modalProductName.text(currentProduct.name);
        modalProductDescription.text(currentProduct.description);

        const discountedPrice = currentProduct.discount
            ? currentProduct.price * (1 - currentProduct.discount / 100)
            : currentProduct.price;

        modalProductPrice.text(`$${discountedPrice.toFixed(2)}`);
        if (currentProduct.discount > 0) {
            modalProductOriginalPrice
                .text(`$${currentProduct.price.toFixed(2)}`)
                .show();
            modalProductDiscount.text(`-${currentProduct.discount}%`).show();
        } else {
            modalProductOriginalPrice.hide();
            modalProductDiscount.hide();
        }

        productQty.val(1);

        stockStatusElement
            .removeClass("text-warning text-danger")
            .addClass(currentProduct.stock > 0 ? "text-warning" : "text-danger")
            .html(
                currentProduct.stock > 0
                    ? '<i class="fas fa-check-circle me-1"></i>In stock'
                    : '<i class="fas fa-times-circle me-1"></i>Out stock'
            );

        if (addToCartModal) addToCartModal.show();
    }

    reinitializeAddToCartButtons();
    updateCartUI();

    // Quantity modal buttons
    $("#increaseQty").on("click", function () {
        productQty.val(parseInt(productQty.val()) + 1);
    });

    $("#decreaseQty").on("click", function () {
        if (parseInt(productQty.val()) > 1) {
            productQty.val(parseInt(productQty.val()) - 1);
        }
    });

    // Confirm Add to Cart
    $("#confirmAddToCart").on("click", function () {
        const quantity = parseInt(productQty.val());
        if (currentProduct.stock <= 0) {
            showCartToast("This item is out of stock!", "danger");
            return;
        }
        if (quantity > currentProduct.stock) {
            showCartToast(`Only ${currentProduct.stock} available!`, "warning");
            return;
        }

        const uniqueId = `${currentProduct.type}_${currentProduct.id}`;
        
        const index = cart.findIndex((item) => 
            `${item.type}_${item.id}` === uniqueId
        );
        
        if (index > -1) {
            cart[index].quantity += quantity;
        } else {
            cart.push({ 
                ...currentProduct, 
                quantity,
                uniqueId: uniqueId
            });
        }

        saveCartToStorage();
        updateCartUI();

        showCartToast(
            `${currentProduct.name} (x${quantity}) added to your cart!`,
            "success"
        );

        if (addToCartModal) addToCartModal.hide();
    });

    function updateCartUI() {
        if (!cartItemsContainer.length) return;

        cartItemsContainer.empty();
        if (cart.length === 0) {
            emptyCartMessage.removeClass("d-none");
            cartSummary.addClass("d-none");
            cartCount.text("0");
            return;
        }

        emptyCartMessage.addClass("d-none");
        cartSummary.removeClass("d-none");

        let subtotal = 0;
        let totalDiscount = 0;

        cart.forEach((item, index) => {
            // Original price per unit
            const originalPrice = parseFloat(item.price);
            const discount = parseFloat(item.discount) || 0;
            const quantity = parseInt(item.quantity);
            
            // Calculate discounted price per unit
            const discountedPrice = discount > 0 
                ? originalPrice * (1 - discount / 100)
                : originalPrice;
            
            // Calculate amounts for this item
            const originalTotal = originalPrice * quantity;
            const discountedTotal = discountedPrice * quantity;
            const itemDiscountAmount = originalTotal - discountedTotal;
            
            // Add to totals
            subtotal += originalTotal;
            totalDiscount += itemDiscountAmount;

            const el = $(`
                <div class="cart-item mb-3" data-index="${index}">
                    <div class="d-flex align-items-center">
                        <img src="${item.img}" class="cart-item-img rounded me-3" style="width:80px;height:80px;">
                        <div class="cart-item-details flex-grow-1">
                            <p class="mb-1 fw-bold">${item.name}</p>
                            ${discount > 0
                                ? `
                                <p class="mb-0">
                                    <span class="fw-bold">$${discountedTotal.toFixed(2)}</span><br>
                                    <span class="text-muted text-decoration-line-through small">$${originalTotal.toFixed(2)}</span><br>
                                    <span class="badge bg-danger">-${discount}%</span>
                                </p>`
                                : `<p class="mb-0 fw-bold">$${originalTotal.toFixed(2)}</p>`
                            }
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm btn-outline-secondary decrease-qty-btn"><i class="fas fa-minus"></i></button>
                        <span class="mx-2 item-quantity">${quantity}</span>
                        <button class="btn btn-sm btn-outline-secondary increase-qty-btn" ${quantity >= item.stock ? "disabled" : ""}><i class="fas fa-plus"></i></button>
                        <button class="btn btn-sm btn-outline-danger remove-item-btn ms-4"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `);
            cartItemsContainer.append(el);
        });

        // Calculate final total
        const finalTotal = subtotal - totalDiscount;

        // Update cart summary with proper rounding
        cartSubtotal.text(`$${subtotal.toFixed(2)}`);
        cartDiscount.text(`-$${totalDiscount.toFixed(2)}`);
        cartTotal.text(`$${finalTotal.toFixed(2)}`);
        
        // Calculate total items in cart
        const totalItems = cart.reduce((total, item) => total + parseInt(item.quantity), 0);
        cartCount.text(totalItems);

        // Button actions (keep the same as your original code)
        $(".remove-item-btn").on("click", function () {
            cart.splice($(this).closest(".cart-item").data("index"), 1);
            saveCartToStorage();
            updateCartUI();
        });

        $(".increase-qty-btn").on("click", function () {
            const i = $(this).closest(".cart-item").data("index");
            if (cart[i].quantity < cart[i].stock) {
                cart[i].quantity++;
                saveCartToStorage();
                updateCartUI();
            }
        });

        $(".decrease-qty-btn").on("click", function () {
            const i = $(this).closest(".cart-item").data("index");
            if (cart[i].quantity > 1) {
                cart[i].quantity--;
                saveCartToStorage();
                updateCartUI();
            }
        });
    }

    function saveCartToStorage() {
        localStorage.setItem("shoppingCart", JSON.stringify(cart));
    }

    // Category filtering
    $(".category-item").on("click", function () {
        const categoryId = $(this).data("category-id");
        filterProductsByCategory(categoryId);
    });

    $("#see-all-btn").on("click", function () {
        resetProductFilter();
    });

    function filterProductsByCategory(categoryId) {
        const allProducts = $(".product-item");
        const categoryTitle = $(`.category-item[data-category-id="${categoryId}"] h5`).text();
        
        let foundProducts = 0;

        $("#products-title").text(categoryTitle);

        allProducts.hide();
        
        allProducts.each(function () {
            if ($(this).data("category-id") === categoryId) {
                $(this).show();
                foundProducts++;
            }
        });

        if (foundProducts === 0) {
            $("#no-products-message").removeClass("d-none");
        } else {
            $("#no-products-message").addClass("d-none");
        }

        $("#see-all-btn").show();
    }

    function resetProductFilter() {
        $(".product-item").show();
        $("#products-title").text("Featured Products");
        $("#see-all-btn").hide();
        $("#no-products-message").addClass("d-none");
    }

    // Checkout form
    $("#checkoutForm").on("submit", function () {
        $("#cartData").val(JSON.stringify(cart));
    });
});