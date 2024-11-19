<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    // Display the list of sales
    public function index()
    {
        $sales = Sale::with(['order', 'product', 'customer'])->get();
        return view('sales.index', compact('sales'));
    }

    // Show the form to create a new sale
    public function create()
    {
        $orders = Order::all();
        $products = Product::all();
        $customers = Customer::all();
        return view('sales.create', compact('orders', 'products', 'customers'));
    }

    // Store a newly created sale in the database
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'customer_id' => 'required|exists:customers,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
        ]);

        // Calculate total price as quantity * price
        $totalPrice = $request->input('quantity') * $request->input('price');

        // Create the sale record
        Sale::create([
            'order_id' => $request->input('order_id'),
            'product_id' => $request->input('product_id'),
            'customer_id' => $request->input('customer_id'),
            'quantity' => $request->input('quantity'),
            'price' => $request->input('price'),
            'total_price' => $totalPrice, // Save the calculated total price
            'sale_date' => $request->input('sale_date'),
        ]);


        return redirect()->route('sales.index')->with('success', 'Sale created successfully.');
    }

    // Display the specified sale
    public function show($id)
    {
        $sale = Sale::with(['order', 'product', 'customer'])->findOrFail($id);

        // Total sales for the product
        $totalSalesForProduct = Sale::where('product_id', $sale->product_id)->sum('total_price');

        // Total quantity sold for the product
        $totalQuantityForProduct = Sale::where('product_id', $sale->product_id)->sum('quantity');

        // Total sales for the customer
        $totalSalesForCustomer = Sale::where('customer_id', $sale->customer_id)->sum('total_price');

        return view('sales.show', compact('sale', 'totalSalesForProduct', 'totalQuantityForProduct', 'totalSalesForCustomer'));
    }

    // Show the form to edit an existing sale
    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        $orders = Order::all();
        $products = Product::all();
        $customers = Customer::all();
        return view('sales.edit', compact('sale', 'orders', 'products', 'customers'));
    }

    // Update the specified sale in the database
    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'customer_id' => 'required|exists:customers,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
        ]);

        // Calculate the total price as quantity * price
        $totalPrice = $validatedData['quantity'] * $validatedData['price'];

        // Find and update the sale record
        $sale = Sale::findOrFail($id);
        $sale->update([
            'order_id' => $validatedData['order_id'],
            'product_id' => $validatedData['product_id'],
            'customer_id' => $validatedData['customer_id'],
            'quantity' => $validatedData['quantity'],
            'price' => $validatedData['price'],
            'total_price' => $totalPrice, // Update the total price
            'sale_date' => $validatedData['sale_date'],
        ]);


        return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
    }

    public function report()
    {
        // Total sales revenue
        $totalRevenue = Sale::sum('total_price');

        // Total quantity of products sold
        $totalQuantity = Sale::sum('quantity');

        // Total number of sales
        $totalSales = Sale::count();

        // Revenue per product
        $revenuePerProduct = Sale::selectRaw('product_id, SUM(total_price) as total_revenue')
            ->groupBy('product_id')
            ->with('product')
            ->get();

        // Quantity sold per product
        $quantityPerProduct = Sale::selectRaw('product_id, SUM(quantity) as total_quantity')
            ->groupBy('product_id')
            ->with('product')
            ->get();

        // Revenue per customer
        $revenuePerCustomer = Sale::selectRaw('customer_id, SUM(total_price) as total_revenue')
            ->groupBy('customer_id')
            ->with('customer')
            ->get();

        return view('sales.report', compact(
            'totalRevenue',
            'totalQuantity',
            'totalSales',
            'revenuePerProduct',
            'quantityPerProduct',
            'revenuePerCustomer'
        ));
    }
    
    // Delete the specified sale
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }
}
