<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Stock;
use App\Models\ProductSize;
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
            'picture_url' => $request->query('picture_url')
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
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'sizes' => 'nullable|array',
            'sizes.*' => 'required|string|in:XS,S,M,L,XL,XXL',
            'category_id' => 'required|exists:categories,id',
            'picture_url' => 'image|nullable|mimes:jpg,jpeg,png,gif,bmp,tiff|max:9999',
        ]);

        // Create the product (only once)
        $product = new Product($request->except('sizes'));

        if ($request->hasFile('picture_url')) {
            $product->picture_url = $request->file('picture_url')->store('picture_url', 'public');
        }

        $product->save();

        // Add sizes
        // Only create sizes if they exist and are valid
        if ($request->has('sizes')) {
            // Ensure only valid sizes in uppercase
            $validSizes = array_intersect(
                array_map('strtoupper', $request->sizes),
                ['XS', 'S', 'M', 'L', 'XL', 'XXL']
            );

            foreach ($validSizes as $size) {
                $product->sizes()->create(['size' => $size]);
            }
        }
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
            'sizes' => 'nullable|array',
            'sizes.*' => 'required|string|in:XS,S,M,L,XL,XXL',
            'stock_quantity' => 'required|integer',
            'category_id' => 'sometimes|required|exists:categories,id',
            'picture_url' => 'nullable|image|mimes:jpg,jpeg,png,gif,bmp,tiff|max:1999',
        ]);

        // Update all attributes except picture_url and sizes
        $product->update($request->except(['picture_url', 'sizes']));

        // Handle picture upload
        if ($request->hasFile('picture_url')) {
            if ($product->picture_url && Storage::exists('public/' . $product->picture_url)) {
                Storage::delete('public/' . $product->picture_url);
            }
            $product->picture_url = $request->file('picture_url')->store('picture_url', 'public');
            $product->save(); // Save the picture_url change
        }

        // Handle sizes
        $product->sizes()->delete();
        if ($request->has('sizes')) {
            foreach ($request->sizes as $size) {
                $product->sizes()->create(['size' => $size]);
            }
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
