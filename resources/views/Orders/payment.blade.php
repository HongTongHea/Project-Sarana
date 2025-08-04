@extends('layouts.app')

@section('title', 'Process Payment - Order #' . $order->id)

@section('content')
    <div class="container-fluid mt-3">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card rounded-0">
                    <div class="card-header">
                        <h4>Process Payment - Order #{{ $order->id }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>{{ $item->item->name }} (x{{ $item->quantity }})</td>
                                            <td>${{ number_format($item->total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td>Subtotal</td>
                                        <td>${{ number_format($order->subtotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Item Discounts</td>
                                        <td>-${{ number_format($order->item_discounts, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Additional Discount</td>
                                        <td>-${{ number_format($order->additional_discount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tax</td>
                                        <td>${{ number_format($order->tax_amount, 2) }}</td>
                                    </tr>
                                    <tr class="table-active">
                                        <td><strong>Total</strong></td>
                                        <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                                    </tr>
                                    <tr class="table-info">
                                        <td>Amount Due</td>
                                        <td>${{ number_format($order->total - $order->paid_amount, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <form action="{{ route('orders.payment.store', $order->id) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="method" class="form-label">Payment Method</label>
                                <select class="form-select" id="method" name="method" required>
                                    <option value="">Select Payment Method</option>
                                    <option value="cash" {{ old('method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="credit_card" {{ old('method') == 'credit_card' ? 'selected' : '' }}>
                                        Credit Card</option>
                                    <option value="debit_card" {{ old('method') == 'debit_card' ? 'selected' : '' }}>Debit
                                        Card</option>
                                    <option value="bank_transfer" {{ old('method') == 'bank_transfer' ? 'selected' : '' }}>
                                        Bank Transfer</option>
                                    <option value="other" {{ old('method') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label">Payment Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount" min="0.01"
                                    max="{{ $order->total - $order->paid_amount }}" step="0.01"
                                    value="{{ old('amount', $order->total - $order->paid_amount) }}" required>
                            </div>

                            <div class="mb-3" id="cash-fields" style="display: none;">
                                <label for="received_amount" class="form-label">Amount Received</label>
                                <input type="number" class="form-control" id="received_amount" name="received_amount"
                                    min="0.01" step="0.01" value="{{ old('received_amount') }}" required>
                                <div class="mt-2">
                                    <strong>Change: </strong><span id="change-amount">$0.00</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
                                <button type="submit" class="btn btn-primary">Process Payment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const methodSelect = document.getElementById('method');
            const cashFields = document.getElementById('cash-fields');
            const amountInput = document.getElementById('amount');
            const receivedInput = document.getElementById('received_amount');
            const changeAmount = document.getElementById('change-amount');

            // Initialize based on selected method (if form was submitted with errors)
            if (methodSelect.value === 'cash') {
                cashFields.style.display = 'block';
                receivedInput.setAttribute('required', 'required');
                if (!receivedInput.value && amountInput.value) {
                    receivedInput.value = amountInput.value;
                }
                calculateChange();
            }

            methodSelect.addEventListener('change', function() {
                if (this.value === 'cash') {
                    cashFields.style.display = 'block';
                    receivedInput.setAttribute('required', 'required');
                    // Only set default value if not already set
                    if (!receivedInput.value && amountInput.value) {
                        receivedInput.value = amountInput.value;
                    }
                    calculateChange();
                } else {
                    cashFields.style.display = 'none';
                    receivedInput.removeAttribute('required');
                    receivedInput.value = ''; // Clear the value for non-cash methods
                }
            });

            amountInput.addEventListener('input', calculateChange);
            receivedInput.addEventListener('input', calculateChange);

            function calculateChange() {
                if (methodSelect.value === 'cash' && receivedInput.value && amountInput.value) {
                    const change = parseFloat(receivedInput.value) - parseFloat(amountInput.value);
                    changeAmount.textContent = '$' + (change > 0 ? change.toFixed(2) : '0.00');
                } else {
                    changeAmount.textContent = '$0.00';
                }
            }
        });
    </script>

@endsection
