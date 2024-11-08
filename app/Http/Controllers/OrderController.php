<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'status' => 'required|in:pending,completed,canceled',
            'payment_status' => 'required|in:paid,unpaid',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        // Calculate total price based on quantity and price
        $validatedData['total_price'] = $validatedData['quantity'] * $validatedData['price'];

        // Create new order with calculated total price
        Order::create($validatedData);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }


    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $customers = Customer::all();
        $products = Product::all();
        return view('orders.edit', compact('order', 'customers', 'products'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Validate incoming request
        $validatedData = $request->validate([
            'status' => 'in:pending,completed,canceled',
            'payment_status' => 'in:paid,unpaid',
            'quantity' => 'integer|min:1',
            'price' => 'numeric|min:0',
        ]);

        // Calculate total price based on quantity and price
        if (isset($validatedData['quantity']) && isset($validatedData['price'])) {
            $validatedData['total_price'] = $validatedData['quantity'] * $validatedData['price'];
        } else {
            $validatedData['total_price'] = $order->quantity * $order->price; // keep the current total if no change
        }

        // Update the order with new data
        $order->update($validatedData);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }


    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
