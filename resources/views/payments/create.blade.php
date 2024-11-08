@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- @if ($order)
            <h2>Create Payment for Order #{{ $order->id }}</h2>
            <!-- Your payment form or other content -->
        @else
            <p>Order not found.</p>
        @endif --}}


        <!-- Payment Form -->
        <form action="{{ route('payments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">

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
                <input type="number" name="amount" id="amount" class="form-control" value="{{ $order->total_price }}"
                    readonly>
            </div>

            <div class="form-group">
                <label for="status">Payment Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="success">Success</option>
                    <option value="failure">Failure</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Submit Payment</button>
        </form>
    </div>
@endsection
