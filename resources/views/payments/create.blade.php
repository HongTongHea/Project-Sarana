@extends('layouts.app')

@section('title', 'Create Payment')

@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-body">
                <h3>Process Payment for Order No: {{ $order->id }}</h3>

                <form action="{{ route('payments.store', $order->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="payment_method">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="form-control" required>
                            <option value="credit_card">Credit Card</option>
                            <option value="cash">Cash</option>
                            <option value="aba">ABA </option>
                            <option value="paypal">PayPal</option>
                            <option value="bank_transfer">Bank Transfer</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" name="amount" id="amount" class="form-control"
                            value="{{ $order->total_price }}" readonly>
                    </div>

                    <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-sm rounded-5 float-end">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm rounded-5 me-1 float-end">Submit Payment</button>
                </form>
            </div>
        </div>
    </div>



@endsection
