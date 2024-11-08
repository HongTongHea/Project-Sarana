@extends('layouts.app')

@section('content')
<h2>Process Payment for Order #{{ $order->id }}</h2>

<form action="{{ route('payments.store', $order->id) }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="payment_method">Payment Method</label>
        <select name="payment_method" id="payment_method" class="form-control" required>
            <option value="credit_card">Credit Card</option>
            <option value="paypal">PayPal</option>
            <option value="bank_transfer">Bank Transfer</option>
        </select>
    </div>

    <div class="form-group">
        <label for="amount">Amount</label>
        <input type="text" name="amount" id="amount" class="form-control" value="{{ $order->total_price }}" readonly>
    </div>

    <button type="submit" class="btn btn-primary">Submit Payment</button>
</form>
@endsection
