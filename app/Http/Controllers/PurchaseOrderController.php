<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Accessory;
use App\Models\Supplier;
use App\Models\Employee;
use App\Models\Stock;
use Illuminate\Support\Facades\Validator;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $orders      = PurchaseOrder::with(['supplier', 'creator'])->latest()->get();
        $suppliers   = Supplier::latest()->get();
        $products    = Product::latest()->get();
        $accessories = Accessory::latest()->get();
        $employees   = Employee::latest()->get();

        return view('purchase_orders.index', compact('orders', 'suppliers', 'products', 'accessories', 'employees'));
    }

    public function create()
    {
        $purchaseOrders = PurchaseOrder::latest()->get();
        $suppliers      = Supplier::latest()->get();
        $products       = Product::latest()->get();
        $accessories    = Accessory::latest()->get();
        $employees      = Employee::latest()->get();

        return view('purchase_orders.create', compact(
            'suppliers',
            'products',
            'accessories',
            'purchaseOrders',
            'employees'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id'          => 'required|exists:suppliers,id',
            'created_by'           => 'required|exists:employees,id',
            'order_date'           => 'required|date',
            'items'                => 'required|array|min:1',
            'items.*.item_type'    => 'required|string|in:product,accessory,App\Models\Product,App\Models\Accessory',
            'items.*.item_id'      => 'required|integer',
            'items.*.quantity'     => 'required|integer|min:1',
            'items.*.unit_price'   => 'required|numeric|min:0',
        ]);

        $order = PurchaseOrder::create([
            'supplier_id'  => $request->supplier_id,
            'created_by'   => $request->created_by,
            'order_date'   => $request->order_date,
            'total_amount' => 0,
            'status'       => 'pending',
        ]);

        foreach ($request->items as $itemData) {
            [$itemTypeClass, $existsRule] = $this->normalizeAndRule($itemData['item_type']);

            // Ensure the item actually exists in its table
            $validator = Validator::make(
                ['item_id' => $itemData['item_id']],
                ['item_id' => "exists:{$existsRule},id"]
            );
            
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $order->items()->create([
                'item_id'     => $itemData['item_id'],
                'item_type'   => $itemTypeClass,
                'quantity'    => $itemData['quantity'],
                'unit_price'  => $itemData['unit_price'],
                'total_price' => $itemData['quantity'] * $itemData['unit_price'],
            ]);
        }

        $order->updateTotalAmount();

        return redirect()->route('purchase_orders.index')->with('success', 'Purchase order created successfully.');
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        // Load polymorphic item relation
        $purchaseOrder->load(['supplier', 'creator', 'items.item']);
        return view('purchase_orders.show', compact('purchaseOrder'));
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be edited.');
        }

        $suppliers      = Supplier::all();
        $products       = Product::all();
        $accessories    = Accessory::all();
        $employees      = Employee::all();

        // Load current items for the form
        $purchaseOrder->load('items.item');

        return view('purchase_orders.edit', compact('purchaseOrder', 'suppliers', 'products', 'accessories', 'employees'));
    }

    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be updated.');
        }

        $request->validate([
            'supplier_id'          => 'required|exists:suppliers,id',
            'created_by'           => 'required|exists:employees,id',
            'order_date'           => 'required|date',
            'items'                => 'required|array|min:1',
            'items.*.item_type'    => 'required|string|in:product,accessory,App\Models\Product,App\Models\Accessory',
            'items.*.item_id'      => 'required|integer',
            'items.*.quantity'     => 'required|integer|min:1',
            'items.*.unit_price'   => 'required|numeric|min:0',
        ]);

        $purchaseOrder->update([
            'supplier_id' => $request->supplier_id,
            'created_by'  => $request->created_by,
            'order_date'  => $request->order_date,
        ]);

        // Replace items
        $purchaseOrder->items()->delete();

        foreach ($request->items as $itemData) {
            [$itemTypeClass, $existsRule] = $this->normalizeAndRule($itemData['item_type']);

            // Ensure the item actually exists in its table
            $validator = Validator::make(
                ['item_id' => $itemData['item_id']],
                ['item_id' => "exists:{$existsRule},id"]
            );
            
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $purchaseOrder->items()->create([
                'item_id'     => $itemData['item_id'],
                'item_type'   => $itemTypeClass,
                'quantity'    => $itemData['quantity'],
                'unit_price'  => $itemData['unit_price'],
                'total_price' => $itemData['quantity'] * $itemData['unit_price'],
            ]);
        }

        $purchaseOrder->updateTotalAmount();

        return redirect()->route('purchase_orders.index')->with('success', 'Purchase order updated successfully.');
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be deleted.');
        }

        $purchaseOrder->items()->delete();
        $purchaseOrder->delete();

        return redirect()->route('purchase_orders.index')->with('success', 'Purchase order deleted successfully.');
    }

    public function markAsReceived(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->markAsReceived()) {
            
            return redirect()->route('purchase_orders.index')->with('success', 'Purchase order marked as received.');
        }

        return redirect()->back()->with('error', 'Order could not be marked as received.');
    }

    /**
     * Normalize incoming item_type to FQCN and return [fqcn, table_name] for exists rule.
     *
     * Accepts: 'product', 'accessory', 'App\Models\Product', 'App\Models\Accessory'
     */
    private function normalizeAndRule(string $type): array
    {
        $t = ltrim($type, '\\');
        if ($t === 'product' || $t === 'App\Models\Product') {
            return [Product::class, 'products'];
        }
        if ($t === 'accessory' || $t === 'App\Models\Accessory') {
            return [Accessory::class, 'accessories'];
        }
        // Fallback (should never hit because of validation)
        return [Product::class, 'products'];
    }
}