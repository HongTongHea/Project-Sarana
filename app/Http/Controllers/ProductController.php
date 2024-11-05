<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    // Display a listing of products
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    // Show the form for creating a new product
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // Store a newly created product in storage
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'size' => 'required|in:XS,S,M,L,XL,XXL',
            'stock_quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'picture_url' => 'image|nullable|max:1999',
        ]);
        
        $product = new Product();
        $product->name = $validatedData['name'];
        $product->description = $validatedData['description'];
        $product->price = $validatedData['price'];
        $product->size = $validatedData['size'];
        $product->stock_quantity = $validatedData['stock_quantity'];
        $product->category_id = $validatedData['category_id'];

        if ($request->hasFile('picture_url')) {
            if ($product->picture_url) {
                Storage::delete('public/' . $product->picture_url);
            }
            $product->picture_url = $request->file('picture_url')->store('picture_url', 'public');
        }

        $product->save();

        // Product::create($validatedData);

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    // Display the specified product
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    // Show the form for editing the specified product
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product'));
    }

    // Update the specified product in storage
    public function update(Request $request, product $product)
    {
    

             $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'size' => 'sometimes|required|in:XS,S,M,L,XL,XXL',
            'stock_quantity' => 'sometimes|required|integer',
            'category_id' => 'sometimes|required|exists:categories,id',
            'picture_url' => 'image|nullable|max:1999',
            ]);

            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->size = $request->size;
            $product->stock_quantity = $request->stock_quantity;
            $product->category_id = $request->category_id;

            if ($request->hasFile('picture_url')) {
                if ($product->picture_url) {
                    Storage::delete('public/' . $product->picture_url);
                }
                $product->picture_url = $request->file('picture_url')->store('picture_url', 'public');
            }
    
            $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    // Remove the specified product from storage
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
