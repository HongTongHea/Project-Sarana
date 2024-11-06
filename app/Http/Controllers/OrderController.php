<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $orders = Order::with('customer')->paginate(10);
        return view('orders.index', compact('orders'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $customers = Customer::all();
        $products = Product::all();

        return view('orders.create', compact('customers', 'products'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
          // Validate the request data
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'status' => 'required|in:pending,completed,canceled',
            'payment_status' => 'required|in:paid,unpaid',
            'total_price' => 'required|numeric|min:0',
            'product_id.*' => 'required|exists:products,id',
            'quantity.*' => 'required|integer|min:1',
            'price.*' => 'required|numeric|min:0',]);


            // Create a new order

            $order = Order::create([
                'customer_id' => $validated['customer_id'],
                'status' => $validated['status'],
                'payment_status' => $validated['payment_status'],
                'total_price' => array_sum(array_map(function ($quantity, $price) {
                    return $quantity * $price;
                }, $validated['quantity'], $validated['price']))
            ]);
             // Create order items
        foreach ($validated['product_id'] as $index => $productId) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $validated['quantity'][$index],
                'price' => $validated['price'][$index],
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Order created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
        $order->load('orderItems.product');
        return view('orders.show', compact('order'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
        $customers = Customer::all();
        $products = Product::all();
        $order->load('orderItems');
        return view('orders.edit', compact('order', 'customers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'status' => 'required|in:pending,completed,canceled',
            'payment_status' => 'required|in:paid,unpaid',
            'product_id' => 'required|array',
            'product_id.*' => 'required|exists:products,id',
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer|min:1',
            'price' => 'required|array',
            'price.*' => 'required|numeric|min:0',
        ]);

        $order->update([
            'customer_id' => $validated['customer_id'],
            'status' => $validated['status'],
            'payment_status' => $validated['payment_status'],
            'total_price' => array_sum(array_map(function ($quantity, $price) {
                return $quantity * $price;
            }, $validated['quantity'], $validated['price']))
        ]);

        // Delete old items and add new ones
        $order->orderItems()->delete();
        foreach ($validated['product_id'] as $index => $productId) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $validated['quantity'][$index],
                'price' => $validated['price'][$index],
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Order updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
        $order->orderItems()->delete();
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully');
    }
}
