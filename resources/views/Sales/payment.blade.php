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
                        <label for="payment-method" class="form-label">Payment Method</label>
                        <select class="form-select" id="payment-method" required>
                            <option value="">Select Payment Method</option>
                            <option value="cash">Cash</option>
                            <option value="aba">ABA</option>
                            <option value="credit_card">Credit Card</option>
                        </select>
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
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-sm" id="confirm-payment">Complete Payment</button>
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
    $(document).ready(function() {
        // Show payment modal on submit-sale click
        $('#submit-sale').on('click', function(e) {
            e.preventDefault();

            if (typeof saleItems === 'undefined' || saleItems.length === 0) {
                alert('Please add at least one item to the sale');
                return;
            }

            const total = parseFloat($('#total').text().replace('$', ''));
            $('#modal-total-amount').text('$' + total.toFixed(2));
            $('#paymentModal').modal('show');
        });

        // Handle payment method change
        $('#payment-method').on('change', function() {
            $('.payment-method-fields').hide();
            const method = $(this).val();

            if (method === 'cash') {
                $('#cash-fields').show();
                const total = parseFloat($('#modal-total-amount').text().replace('$', '')) || 0;
                $('#cash-received').val(total.toFixed(2));
                $('#change-amount').text('$0.00');
                $('#change-display').hide();
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

            // Add hidden input to form
            $('#sale-form').append(
                `<input type="hidden" name="payment_data" value='${JSON.stringify(paymentData)}'>`
            );

            // Submit the form
            $('#sale-form').off('submit').submit();
        });
    });
</script>
