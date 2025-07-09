<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Stock;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('products.index', compact('products', 'categories'));
    }

    public function showDetail(Request $request)
    {
        $productId = $request->query('id');
        $product = Product::findOrFail($productId);

        return view('products.detail', [
            'product' => $product,
            'name' => $request->query('name'),
            'price' => $request->query('price'),
            'picture_url' => $request->query('picture_url'),
            'discount_percentage' => $request->query('discount_percentage')
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        $stocks = Stock::all();
        return view('products.create', compact('categories', 'stocks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'barcode' => 'nullable|string|max:255|unique:products',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'picture_url' => 'image|nullable|mimes:jpg,jpeg,png,gif,bmp,tiff|max:30',
        ]);

        $product = new Product($request->all());

        if ($request->hasFile('picture_url')) {
            $product->picture_url = $request->file('picture_url')->store('picture_url', 'public');
        }

        $product->save();

        // Auto-insert stock record
        $existingStock = $product->stocks()->where('type', 'initial')->first();

        if (!$existingStock) {
            $product->stocks()->create([
                'quantity' => $product->stock_quantity,
                'type' => 'initial',
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $stocks = Stock::all();
        return view('products.edit', compact('product', 'categories', 'stocks'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'brand' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'stock_quantity' => 'required|integer',
            'category_id' => 'sometimes|required|exists:categories,id',
            'barcode' => 'nullable|string|max:255|unique:products,barcode,' . $product->id,
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'picture_url' => 'nullable|image|mimes:jpg,jpeg,png,gif,bmp,tiff|max:30',
        ]);

        $product->update($request->except('picture_url'));

        if ($request->hasFile('picture_url')) {
            if ($product->picture_url && Storage::exists('public/' . $product->picture_url)) {
                Storage::delete('public/' . $product->picture_url);
            }
            $product->picture_url = $request->file('picture_url')->store('picture_url', 'public');
            $product->save();
        }

        // Update stock record
        $product->stocks()->updateOrCreate(
            ['product_id' => $product->id],
            [
                'quantity' => $request->stock_quantity,
                'type' => 'update',
            ]
        );

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->picture_url) {
            Storage::delete('public/' . $product->picture_url);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
