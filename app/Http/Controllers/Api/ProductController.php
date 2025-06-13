<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Stock;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category', 'stock', 'sizes')->get();
        return response()->json(
            [
                'success' => true,
                'data' => $products
            ]
        );

        // $products = Product::all();
        // return response()->json(['data' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'sizes' => 'nullable|array',
            'sizes.*' => 'in:XS,S,M,L,XL,XXL',
            'category_id' => 'required|exists:categories,id',
            'picture_url' => 'image|nullable|mimes:jpg,jpeg,png,gif,bmp,tiff|max:9999',
            'stock_quantity' => 'required|integer|min:0'
        ]);

        // Handle file upload
        if ($request->hasFile('picture_url')) {
            $validated['picture_url'] = $request->file('picture_url')->store('products', 'public');
        }

        $product = Product::create($validated);

        // Add sizes
        if ($request->has('sizes')) {
            foreach ($request->sizes as $size) {
                $product->sizes()->create(['size' => $size]);
            }
        }

        // Create initial stock record
        $product->stocks()->create([
            'quantity' => $product->stock_quantity,
            'type' => 'initial'
        ]);

        return response()->json([
            'success' => true,
            'data' => $product->load(['category', 'sizes', 'stocks']),
            'message' => 'Product created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
