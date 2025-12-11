<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Payment Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="payment-form">
                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>

                        <!-- Hidden select for form submission -->
                        <select class="form-select" id="payment-method" required style="display: none;">
                            <option value="">Select Payment Method</option>
                            <option value="cash">Cash</option>
                            <option value="aba">ABA</option>
                            <option value="acleda">ACLEDA</option>
                            <option value="credit_card">Credit Card</option>
                        </select>

                        <!-- Custom dropdown display -->
                        <div class="custom-select-wrapper">
                            <button type="button"
                                class="btn btn-outline-secondary w-100 text-start d-flex align-items-center justify-content-between"
                                id="payment-dropdown-btn">
                                <span id="selected-payment">
                                    <i class="bi bi-wallet2 text-muted"></i> Select Payment Method
                                </span>
                                <i class="bi bi-chevron-down"></i>
                            </button>

                            <div class="payment-dropdown-menu" style="display: none;">
                                <div class="payment-option" data-value="cash">
                                    <i class="bi bi-cash-coin text-success"></i>
                                    <span>Cash</span>
                                </div>
                                <div class="payment-option" data-value="aba">
                                    <i class="bi bi-credit-card-fill text-warning"></i>
                                    <span>ABA Pay</span>
                                </div>
                                <div class="payment-option" data-value="acleda">
                                    <i class="bi bi-credit-card-fill text-info"></i>
                                    <span>ACLEDA Bank</span>
                                </div>
                                <div class="payment-option" data-value="credit_card">
                                    <i class="bi bi-credit-card text-danger"></i>
                                    <span>Credit Card</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cash Fields -->
                    <div id="cash-fields" class="payment-method-fields" style="display: none;">
                        <div class="mb-3">
                            <label for="cash-received" class="form-label">Amount Received</label>
                            <input type="number" class="form-control" id="cash-received" step="0.01" min="0">
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mb-3">
                        <label for="payment-notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="payment-notes" rows="2"></textarea>
                    </div>

                    <!-- Totals and Change -->
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>Total Amount:</strong>
                            <span id="modal-total-amount">$0.00</span>
                        </div>
                        <div id="change-display" style="display: none;">
                            <strong>Change:</strong>
                            <span id="change-amount">$0.00</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i
                        class="fas fa-times me-1"></i>Cancel</button>
                <button type="button" class="btn btn-primary btn-sm" id="confirm-payment"><i
                        class="bi bi-check-lg"></i> Complete Payment</button>
            </div>
        </div>
    </div>
</div>

<!-- Invoice Print Section (optional) -->
<div id="invoice-section" style="display: none; padding: 20px; background: white;">
    <div id="invoice-content"></div>
    <div class="text-center mt-3">
        <button class="btn btn-primary" onclick="printInvoice()">Print Invoice</button>
        <button class="btn btn-secondary" onclick="closeInvoice()">Close</button>
    </div>
</div>

<!-- jQuery (required for script) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Custom payment dropdown
    const dropdownBtn = document.getElementById('payment-dropdown-btn');
    const dropdownMenu = document.querySelector('.payment-dropdown-menu');
    const selectedPaymentSpan = document.getElementById('selected-payment');
    const hiddenSelect = document.getElementById('payment-method');

    // Toggle dropdown
    dropdownBtn.addEventListener('click', function(e) {
        e.preventDefault();
        dropdownMenu.style.display = dropdownMenu.style.display === 'none' ? 'block' : 'none';
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.custom-select-wrapper')) {
            dropdownMenu.style.display = 'none';
        }
    });

    // Handle option selection
    document.querySelectorAll('.payment-option').forEach(option => {
        option.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            const icon = this.querySelector('i').className;
            const text = this.querySelector('span').textContent;

            // Update display
            selectedPaymentSpan.innerHTML = `<i class="${icon}"></i> ${text}`;

            // Update hidden select
            hiddenSelect.value = value;
            $(hiddenSelect).trigger('change'); // Trigger jQuery change event

            // Close dropdown
            dropdownMenu.style.display = 'none';
        });
    });
</script>
<style>
    .custom-select-wrapper {
        position: relative;
    }

    .payment-dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        margin-top: 4px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        max-height: 300px;
        overflow-y: auto;
    }

    .payment-option {
        padding: 12px 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: background-color 0.2s;
    }

    .payment-option:hover {
        background-color: #f8f9fa;
    }

    .payment-option i {
        font-size: 20px;
        width: 24px;
    }

    .payment-option span {
        font-weight: 500;
    }

    #payment-dropdown-btn {
        padding: 10px 16px;
    }

    #payment-dropdown-btn i:first-child {
        margin-right: 8px;
    }
</style>
<script>
    $(document).ready(function() {
        // Check if we're in edit mode and load existing payment data
        const isEditMode = true; // Always true in edit mode
        let existingPayment = null;

        if (typeof salePayment !== 'undefined') {
            existingPayment = salePayment;
        }

        // Show payment modal on submit-sale click
        $('#submit-sale').on('click', function(e) {
            e.preventDefault();

            if (typeof saleItems === 'undefined' || saleItems.length === 0) {
                alert('Please add at least one item to the sale');
                return;
            }

            const total = parseFloat($('#total').text().replace('$', ''));
            $('#modal-total-amount').text('$' + total.toFixed(2));

            // Load existing payment data if in edit mode
            if (existingPayment) {
                $('#payment-method').val(existingPayment.method).trigger('change');
                $('#payment-notes').val(existingPayment.notes || '');

                if (existingPayment.method === 'cash' && existingPayment.received) {
                    $('#cash-received').val(existingPayment.received.toFixed(2));

                    // Calculate and show change
                    const change = existingPayment.received - total;
                    if (change >= 0) {
                        $('#change-amount').text('$' + change.toFixed(2));
                        $('#change-display').show();
                    }
                }
            }

            $('#paymentModal').modal('show');
        });

        // Handle payment method change
        $('#payment-method').on('change', function() {
            $('.payment-method-fields').hide();
            const method = $(this).val();

            if (method === 'cash') {
                $('#cash-fields').show();
                const total = parseFloat($('#modal-total-amount').text().replace('$', '')) || 0;

                // Only auto-fill if not already filled (from edit mode)
                if (!$('#cash-received').val()) {
                    $('#cash-received').val(total.toFixed(2));
                }

                // Trigger calculation
                $('#cash-received').trigger('input');
            }
        });

        // Calculate change
        $('#cash-received').on('input', function() {
            const total = parseFloat($('#modal-total-amount').text().replace('$', ''));
            const received = parseFloat($(this).val()) || 0;

            if (received >= total) {
                const change = received - total;
                $('#change-amount').text('$' + change.toFixed(2));
                $('#change-display').show();
            } else {
                $('#change-display').hide();
            }
        });

        // Confirm payment
        $(document).on('click', '#confirm-payment', function() {
            const paymentMethod = $('#payment-method').val();
            if (!paymentMethod) {
                alert('Please select a payment method');
                return;
            }

            const total = parseFloat($('#modal-total-amount').text().replace('$', ''));

            if (paymentMethod === 'cash') {
                const received = parseFloat($('#cash-received').val()) || 0;
                if (received < total) {
                    alert('Amount received must be at least equal to the total amount');
                    return;
                }
            }

            const paymentData = {
                method: paymentMethod,
                amount: total,
                notes: $('#payment-notes').val()
            };

            if (paymentMethod === 'cash') {
                paymentData.received = parseFloat($('#cash-received').val());
                paymentData.change = parseFloat($('#change-amount').text().replace('$', '')) || 0;
            }

            // Remove existing payment_data hidden input if exists
            $('input[name="payment_data"]').remove();

            // Add hidden input to form
            $('#sale-form').append(
                `<input type="hidden" name="payment_data" value='${JSON.stringify(paymentData)}'>`
            );

            // Submit the form
            $('#sale-form').off('submit').submit();
        });
    });
</script>
