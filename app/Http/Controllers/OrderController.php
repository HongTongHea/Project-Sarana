<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Accessory;
use App\Models\Payment;
use App\Models\Category;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $customers = Customer::all();
        $products = Product::where('stock_quantity', '>', 0)->get();
        $accessories = Accessory::where('stock_quantity', '>', 0)->get();
        $orders = Order::with(['customer', 'items.product', 'items.accessory', 'payments'])->get();

        return view('orders.index', compact('orders', 'customers', 'products', 'accessories', 'categories'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('stock_quantity', '>', 0)->get();
        $accessories = Accessory::where('stock_quantity', '>', 0)->get();
        $categories = Category::all();
        return view('orders.create', compact('customers', 'products', 'accessories', 'categories'));
    }

    public function store(Request $request)
    {
        // Decode the JSON items and item types
        $items = json_decode($request->input('items'), true);
        $itemTypes = json_decode($request->input('item_types'), true);

        // Validate the items array
        if (!is_array($items)) {
            return redirect()->back()->withErrors(['items' => 'The items must be a valid array.']);
        }

        // Validate incoming request
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'additional_discount' => 'nullable|numeric|min:0',
        ]);

        // Validate each item and check stock availability
        foreach ($items as $index => $item) {
            if (!isset($item['item_id']) || !isset($item['quantity']) || !isset($item['price'])) {
                return redirect()->back()->withErrors(['items' => 'Each item must have item_id, quantity, and price.']);
            }

            $itemType = $itemTypes[$index] ?? null;
            if (!in_array($itemType, ['product', 'accessory'])) {
                return redirect()->back()->withErrors(['items' => 'Invalid item type.']);
            }

            $model = $itemType === 'product' ? Product::class : Accessory::class;
            $itemModel = $model::find($item['item_id']);

            if (!$itemModel) {
                return redirect()->back()->withErrors(['items' => ucfirst($itemType) . ' not found.']);
            }

            if ($itemModel->stock_quantity < $item['quantity']) {
                return redirect()->back()->withErrors([
                    'items' => "Not enough stock for {$itemModel->name}. Available: {$itemModel->stock_quantity}"
                ]);
            }
        }

        // Calculate totals
        $subtotal = 0;
        $itemDiscounts = 0;

        foreach ($items as $index => $item) {
            $itemType = $itemTypes[$index];
            $model = $itemType === 'product' ? Product::class : Accessory::class;
            $itemModel = $model::find($item['item_id']);

            $discountPercentage = $item['discount_percentage'] ?? 0;
            $discountedPrice = $discountPercentage > 0
                ? $item['price'] * (1 - $discountPercentage / 100)
                : $item['price'];

            $subtotal += $item['quantity'] * $item['price'];
            $itemDiscounts += ($item['price'] - $discountedPrice) * $item['quantity'];
        }

        $discountedSubtotal = $subtotal - $itemDiscounts;
        $taxAmount = $discountedSubtotal * ($validatedData['tax_rate'] ?? 0) / 100;
        $additionalDiscount = $validatedData['additional_discount'] ?? 0;
        $total = $discountedSubtotal + $taxAmount - $additionalDiscount;

        // Create order
        $order = Order::create([
            'customer_id' => $validatedData['customer_id'],
            'subtotal' => $subtotal,
            'item_discounts' => $itemDiscounts,
            'additional_discount' => $additionalDiscount,
            'tax_amount' => $taxAmount,
            'total' => $total,
            'status' => 'completed',
            'payment_status' => 'paid',
        ]);

        // Add order items and update stock
        foreach ($items as $index => $item) {
            $itemType = $itemTypes[$index];
            $model = $itemType === 'product' ? Product::class : Accessory::class;
            $itemModel = $model::find($item['item_id']);

            $discountPercentage = $item['discount_percentage'] ?? 0;
            $discountedPrice = $discountPercentage > 0
                ? $item['price'] * (1 - $discountPercentage / 100)
                : $item['price'];

            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'item_type' => $model,
                'item_id' => $item['item_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'discount_percentage' => $discountPercentage,
                'discounted_price' => $discountedPrice,
                'total' => $item['quantity'] * $discountedPrice,
            ]);

            // Update product/accessory stock
            $itemModel->stock_quantity -= $item['quantity'];
            $itemModel->save();
        }

        // Process payment if payment data exists
        if ($request->has('payment_data')) {
            $paymentData = json_decode($request->input('payment_data'), true);

            $payment = Payment::create([
                'order_id' => $order->id,
                'method' => $paymentData['method'],
                'amount' => $paymentData['amount'],
                'received_amount' => $paymentData['received'] ?? null,
                'reference' => $paymentData['reference'] ?? null,
                'notes' => $paymentData['notes'] ?? null,
                'status' => 'completed'
            ]);
        }

        return redirect()->route('orders.invoice', $order->id)
            ->with('success', 'Order created successfully.');
    }

    public function show($id)
    {
        $order = Order::with(['customer', 'items.product', 'items.accessory', 'payments'])->findOrFail($id);
        return view('orders.show', compact('order',));
    }

    public function invoice($id)
    {
        $order = Order::with(['customer', 'items.product', 'items.accessory', 'payments'])
            ->findOrFail($id);

        return view('orders.invoice', compact('order'));
    }

    public function printInvoice($id)
    {
        $order = Order::with(['customer', 'items.product', 'items.accessory', 'payments'])
            ->findOrFail($id);

        return view('orders.print-invoice', compact('order'));
    }

    public function searchProducts(Request $request)
    {
        $search = $request->input('search');
        $products = Product::where('stock_quantity', '>', 0)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('stock_no', 'like', "%{$search}%");
            })
            ->get();

        return response()->json($products);
    }

    public function searchAccessories(Request $request)
    {
        $search = $request->input('search');
        $accessories = Accessory::where('stock_quantity', '>', 0)
            ->where('name', 'like', "%{$search}%")
            ->get();

        return response()->json($accessories);
    }
}
