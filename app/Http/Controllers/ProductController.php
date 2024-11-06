<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'size' => 'required|in:XS,S,M,L,XL,XXL',
            'stock_quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'file' => 'nullable|mimes:jpg,jpeg,png,gif,bmp,tiff,pdf,doc,docx,xlsx,xls|max:1999',
        ]);

        $product = new Product($request->all());

        if ($request->hasFile('file')) {
            $product->picture_url = $request->file('file')->store('uploads', 'public');
        }

        $product->save();

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
        return view('products.edit', compact('product', 'categories'));
    }


    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'size' => 'sometimes|required|in:XS,S,M,L,XL,XXL',
            'stock_quantity' => 'sometimes|required|integer',
            'category_id' => 'sometimes|required|exists:categories,id',
            'file' => 'nullable|mimes:jpg,jpeg,png,gif,bmp,tiff,pdf,doc,docx,xlsx,xls|max:1999',
        ]);

        $product->update($request->except(['file']));

        if ($request->hasFile('file')) {
            if ($product->picture_url) {
                Storage::delete('public/' . $product->picture_url);
            }
            $product->picture_url = $request->file('file')->store('uploads', 'public');
        }

        $product->save();

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
