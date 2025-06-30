<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'items.product'])->get();
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
        // Decode the JSON items first
        $items = json_decode($request->input('items'), true);

        // Validate the items array
        if (!is_array($items)) {
            return redirect()->back()->withErrors(['items' => 'The items must be a valid array.']);
        }

        // Validate incoming request
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount' => 'nullable|numeric|min:0',
        ]);

        // Validate each item and check stock availability
        foreach ($items as $item) {
            if (!isset($item['product_id']) || !isset($item['quantity']) || !isset($item['price'])) {
                return redirect()->back()->withErrors(['items' => 'Each item must have product_id, quantity, and price.']);
            }

            $product = Product::find($item['product_id']);
            if (!$product) {
                return redirect()->back()->withErrors(['items' => 'Product not found.']);
            }

            if ($product->stock_quantity < $item['quantity']) {
                return redirect()->back()->withErrors([
                    'items' => "Not enough stock for {$product->name}. Available: {$product->stock_quantity}"
                ]);
            }
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['quantity'] * $item['price'];
        }

        $taxAmount = $subtotal * ($validatedData['tax_rate'] ?? 0) / 100;
        $discountAmount = $validatedData['discount'] ?? 0;
        $total = $subtotal + $taxAmount - $discountAmount;

        // Create order
        $order = Order::create([
            'customer_id' => $validatedData['customer_id'],
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'total' => $total,
            'status' => 'completed',
            'payment_status' => 'paid',
        ]);

        // Add order items and update stock
        foreach ($items as $item) {
            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['quantity'] * $item['price'],
            ]);

            // Update product stock
            $product = Product::find($item['product_id']);
            $product->stock_quantity -= $item['quantity'];
            $product->save();

            // Create stock movement record
            $product->stocks()->create([
                'quantity' => -$item['quantity'], // Negative for deduction
                'type' => 'sale',
            ]);
        }

        return redirect()->route('orders.show', $order->id)->with('success', 'Order created successfully.');
    }

    public function show($id)
    {
        $order = Order::with(['customer', 'items.product'])->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function searchProducts(Request $request)
    {
        $search = $request->input('search');
        $products = Product::where('name', 'like', "%{$search}%")
            ->orWhere('stock_no', 'like', "%{$search}%")
            ->get();

        return response()->json($products);
    }
}
