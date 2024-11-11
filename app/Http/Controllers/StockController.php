<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $stocks = Stock::all();
        return view('stocks.index', compact('stocks', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $products = Product::all();
        return view('stocks.create', compact('products'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        Stock::create($validatedData);

        return redirect()->route('stocks.index')->with('success', 'Stock created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        $products = Product::all();
        $stocks = Stock::all();
        return view('stocks.index', compact('stock', 'stocks', 'products'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $stock->update($validatedData);

        return redirect()->route('stocks.index')->with('success', 'Stock updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stocks.index')->with('success', 'Stock deleted successfully');
    }
}
