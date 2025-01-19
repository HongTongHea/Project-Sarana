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
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'size' => 'required|in:XS,S,M,L,XL,XXL',
            'category_id' => 'required|exists:categories,id',
            'picture_url' => 'image|nullable|mimes:jpg,jpeg,png,gif,bmp,tiff|max:1999',
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
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'size' => 'sometimes|required|in:XS,S,M,L,XL,XXL',
            'stock_quantity' => 'required|integer',
            'category_id' => 'sometimes|required|exists:categories,id',
            'picture_url' => 'nullable|image|mimes:jpg,jpeg,png,gif,bmp,tiff|max:1999',
        ]);

        $product->update($request->except(['picture_url']));

        if ($request->hasFile('picture_url')) {
            if ($product->picture_url && Storage::exists('public/' . $product->picture_url)) {
                Storage::delete('public/' . $product->picture_url);
            }
            $product->picture_url = $request->file('picture_url')->store('picture_url', 'public');
        }

        $product->save();

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
