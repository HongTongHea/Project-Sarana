<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(Order $order)
    {
        if ($order->status !== 'completed' || $order->payment_status !== 'unpaid') {
            return redirect()->back()->with('error', 'Order is not eligible for payment.');
        }

        return view('payments.create', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        $request->validate([
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer',
            'amount' => 'required|numeric|min:0'
        ]);

        $payment = new Payment([
            'order_id' => $order->id,
            'payment_method' => $request->input('payment_method'),
            'amount' => $request->input('amount'),
            'status' => 'success',  // In a real system, this would be determined by a payment gateway response
        ]);

        $payment->save();

        // Update the order's payment status to "paid" if payment is successful
        if ($payment->status === 'success') {
            $order->update(['payment_status' => 'paid']);
        }

        return redirect()->route('orders.show', $order->id)->with('success', 'Payment processed successfully.');
    }
}
