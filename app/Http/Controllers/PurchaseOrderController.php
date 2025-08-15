<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;


class PurchaseOrderController extends Controller
{

    public function index()
    {
        $orders     = PurchaseOrder::with(['supplier', 'creator'])->latest()->get();
        $suppliers  = Supplier::all();
        $products   = Product::all();
        $employees  = Employee::all(); // fetch all employees

        return view('purchase_orders.index', compact('orders', 'suppliers', 'products', 'employees'));
    }

    public function create()
    {
        $purchaseOrders = PurchaseOrder::all();
        $suppliers      = Supplier::all();
        $products       = Product::all();
        $employees      = Employee::all();

        return view('purchase_orders.create', compact('suppliers', 'products', 'purchaseOrders', 'employees'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'employee_id' => 'required|exists:employees,id',
            'order_date' => 'required|date',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $order = PurchaseOrder::create([
            'supplier_id' => $request->supplier_id,
            'employee_id' => $request->employee_id,
            'created_by'  => Auth::id(),
            'order_date'  => $request->order_date,
            'total_amount' => 0,
            'status'      => 'pending'
        ]);

        foreach ($request->items as $itemData) {
            $order->items()->create([
                'product_id' => $itemData['product_id'],
                'quantity' => $itemData['quantity'],
                'unit_price' => $itemData['unit_price'],
                'total_price' => $itemData['quantity'] * $itemData['unit_price'],
            ]);
        }

        $order->updateTotalAmount();

        return redirect()->route('purchase_orders.index')->with('success', 'Purchase order created successfully.');
    }


    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load(['supplier', 'creator', 'items.product']);
        return view('purchase_orders.show', compact('purchaseOrder'));
    }


    public function edit(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be edited.');
        }

        $suppliers = Supplier::all();
        $products = Product::all();
        $purchaseOrder->load('items');

        return view('purchase_orders.edit', compact('purchaseOrder', 'suppliers', 'products'));
    }


    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be updated.');
        }

        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $purchaseOrder->update([
            'supplier_id' => $request->supplier_id,
            'order_date' => $request->order_date,
        ]);

        $purchaseOrder->items()->delete();

        foreach ($request->items as $itemData) {
            $purchaseOrder->items()->create([
                'product_id' => $itemData['product_id'],
                'quantity' => $itemData['quantity'],
                'unit_price' => $itemData['unit_price'],
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
            return redirect()->route('purchase_orders.index')->with('success', 'Purchase order marked as received and stock updated.');
        }

        return redirect()->back()->with('error', 'Order could not be marked as received.');
    }
}
