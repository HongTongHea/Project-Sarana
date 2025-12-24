<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Accessory;
use App\Models\Payment;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Stock;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $customers = Customer::all();
        $employees = Employee::where('status', 1)->get();
        $products = Product::where('stock_quantity', '>', 0)->get();
        $accessories = Accessory::where('stock_quantity', '>', 0)->get();
        $sales = Sale::with(['customer', 'employee', 'items.product', 'items.accessory', 'payments'])->get();

        return view('sales.index', compact('sales', 'customers', 'employees', 'products', 'accessories', 'categories'));
    }

    public function create()
    {
        $customers = Customer::all();
        $employees = Employee::where('status', 1)->get();
        $products = \App\Models\Product::where('stock_quantity', '>', 0)->paginate(12);
        $accessories = \App\Models\Accessory::where('stock_quantity', '>', 0)->paginate(12);
        $categories = Category::all();
        return view('sales.create', compact('customers', 'employees', 'products', 'accessories', 'categories'));
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
            'employee_id' => 'required|exists:employees,id',
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

        // Create sale
        $sale = Sale::create([
            'customer_id' => $validatedData['customer_id'],
            'employee_id' => $validatedData['employee_id'],
            'subtotal' => $subtotal,
            'item_discounts' => $itemDiscounts,
            'additional_discount' => $additionalDiscount,
            'tax_amount' => $taxAmount,
            'total' => $total,
            'status' => 'completed',
            'payment_status' => 'paid',
        ]);

        // Add sale items and update stock
        foreach ($items as $index => $item) {
            $itemType = $itemTypes[$index];
            $model = $itemType === 'product' ? Product::class : Accessory::class;
            $itemModel = $model::find($item['item_id']);

            $discountPercentage = $item['discount_percentage'] ?? 0;
            $discountedPrice = $discountPercentage > 0
                ? $item['price'] * (1 - $discountPercentage / 100)
                : $item['price'];

            // Create sale item
            SaleItem::create([
                'sale_id' => $sale->id,
                'item_type' => $model,
                'item_id' => $item['item_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'discount_percentage' => $discountPercentage,
                'discounted_price' => $discountedPrice,
                'total' => $item['quantity'] * $discountedPrice,
            ]);

            // Update stock using Stock model
            Stock::updateStock(
                $model,
                $item['item_id'],
                -$item['quantity'], // Negative for sale
                'sale'
            );
        }

        // Process payment if payment data exists
        if ($request->has('payment_data')) {
            $paymentData = json_decode($request->input('payment_data'), true);

            $payment = Payment::create([
                'sale_id' => $sale->id,
                'method' => $paymentData['method'],
                'amount' => $paymentData['amount'],
                'received_amount' => $paymentData['received'] ?? null,
                'reference' => $paymentData['reference'] ?? null,
                'notes' => $paymentData['notes'] ?? null,
                'status' => 'completed'
            ]);
        }

        return redirect()->route('sales.invoice', $sale->id)
            ->with('success', 'Sale created successfully.');
    }

    public function show($id)
    {
        $sale = Sale::with(['customer', 'employee', 'items.product', 'items.accessory', 'payments'])->findOrFail($id);
        return view('sales.show', compact('sale'));
    }

    public function invoice($id)
    {
        $sale = Sale::with(['customer', 'employee', 'items.product', 'items.accessory', 'payments'])
            ->findOrFail($id);

        return view('sales.invoice', compact('sale'));
    }

    public function printInvoice($id)
    {
        $sale = Sale::with(['customer', 'employee', 'items.product', 'items.accessory', 'payments'])
            ->findOrFail($id);

        return view('sales.print-invoice', compact('sale'));
    }

    public function edit($id)
    {
        $sale = Sale::with(['customer', 'employee', 'items.product', 'items.accessory', 'payments'])
            ->findOrFail($id);

        // Load all items with their images
        foreach ($sale->items as $item) {
            if ($item->item_type === 'App\Models\Product' && $item->product) {
                $item->picture_url = $item->product->picture_url ?? $item->picture_url;
                $item->stock_quantity = $item->product->stock_quantity;
            } elseif ($item->item_type === 'App\Models\Accessory' && $item->accessory) {
                $item->picture_url = $item->accessory->picture_url ?? $item->picture_url;
                $item->stock_quantity = $item->accessory->stock_quantity;
            }
        }

        $customers = Customer::all();
        $employees = Employee::where('status', 1)->get();
        $products = Product::where('stock_quantity', '>', 0)->paginate(12);
        $accessories = Accessory::where('stock_quantity', '>', 0)->paginate(12);
        $categories = Category::all();
        
        // Get the first payment (assuming one payment per sale)
        $payment = $sale->payments->first();

        return view('sales.edit', compact('sale', 'customers', 'employees', 'products', 'accessories', 'categories', 'payment'));
    }

    public function update(Request $request, $id)
    {
    $sale = Sale::with(['items', 'payments'])->findOrFail($id);

    // Decode new items
    $items = json_decode($request->input('items'), true);
    $itemTypes = json_decode($request->input('item_types'), true);

    if (!is_array($items)) {
        return redirect()->back()->withErrors(['items' => 'The items must be a valid array.']);
    }

    $validatedData = $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'employee_id' => 'required|exists:employees,id',
        'tax_rate' => 'nullable|numeric|min:0|max:100',
        'additional_discount' => 'nullable|numeric|min:0',
    ]);

    // Restore stock from old items before re-calculation
    foreach ($sale->items as $oldItem) {
        $model = $oldItem->item_type;
        Stock::updateStock(
            $model,
            $oldItem->item_id,
            $oldItem->quantity, // Positive to restore
            'return'
        );
        $oldItem->delete(); // remove old sale items
    }

    // Calculate new totals
    $subtotal = 0;
    $itemDiscounts = 0;

    foreach ($items as $index => $item) {
        $itemType = $itemTypes[$index] ?? null;
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

    // Update sale
    $sale->update([
        'customer_id' => $validatedData['customer_id'],
        'employee_id' => $validatedData['employee_id'],
        'subtotal' => $subtotal,
        'item_discounts' => $itemDiscounts,
        'additional_discount' => $additionalDiscount,
        'tax_amount' => $taxAmount,
        'total' => $total,
    ]);

    // Add new items and update stock
    foreach ($items as $index => $item) {
        $itemType = $itemTypes[$index];
        $model = $itemType === 'product' ? Product::class : Accessory::class;
        $itemModel = $model::find($item['item_id']);

        $discountPercentage = $item['discount_percentage'] ?? 0;
        $discountedPrice = $discountPercentage > 0
            ? $item['price'] * (1 - $discountPercentage / 100)
            : $item['price'];

        SaleItem::create([
            'sale_id' => $sale->id,
            'item_type' => $model,
            'item_id' => $item['item_id'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
            'discount_percentage' => $discountPercentage,
            'discounted_price' => $discountedPrice,
            'total' => $item['quantity'] * $discountedPrice,
        ]);

        // Update stock using Stock model
        Stock::updateStock(
            $model,
            $item['item_id'],
            -$item['quantity'], // Negative for sale
            'sale'
        );
    }

    // Handle payment update
    $paymentData = $request->input('payment_data');
    if ($paymentData) {
        $paymentData = json_decode($paymentData, true);
        
        // Update or create payment
        $payment = $sale->payments()->first();
        
        $paymentRecord = [
            'method' => $paymentData['method'],
            'amount' => $paymentData['amount'],
            'notes' => $paymentData['notes'] ?? null,
            'received' => $paymentData['received'] ?? null,
            'change' => $paymentData['change'] ?? null,
        ];
        
        if ($payment) {
            // Update existing payment
            $payment->update($paymentRecord);
        } else {
            // Create new payment if it doesn't exist
            $sale->payments()->create($paymentRecord);
        }
    }

    return redirect()->route('sales.invoice', $sale->id)
        ->with('success', 'Sale updated successfully.');
}

    public function searchProducts(Request $request)
    {
        $search = $request->input('search');
        $products = Product::where('stock_quantity', '>', 0)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%");
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

    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);

        // Add any validation logic here (e.g., only allow deletion of certain status sales)
        if ($sale->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending sales can be deleted.');
        }

        // Restore stock before deletion
        foreach ($sale->items as $item) {
            $model = $item->item_type;
            Stock::updateStock(
                $model,
                $item->item_id,
                $item->quantity, // Positive to restore
                'return'
            );
        }

        // Delete related records
        $sale->items()->delete();
        $sale->payments()->delete();

        // Delete the sale
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }
}
