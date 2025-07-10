<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use Illuminate\Http\Request;
use App\Models\Stock;
use Illuminate\Support\Facades\Storage;

class AccessoryController extends Controller
{
    public function index()
    {
        $accessories = Accessory::all();
        return view('accessories.index', compact('accessories'));
    }

    public function showDetail(Request $request)
    {
        $accessoryId = $request->query('id');
        $accessory = Accessory::findOrFail($accessoryId);

        return view('accessories.detail', [
            'accessory' => $accessory,
            'name' => $request->query('name'),
            'price' => $request->query('price'),
            'picture_url' => $request->query('picture_url'),
            'discount_percentage' => $request->query('discount_percentage')
        ]);
    }

    public function create()
    {
        $stocks = Stock::all();
        return view('accessories.create', compact('stocks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'picture_url' => 'image|nullable|mimes:jpg,jpeg,png,gif,bmp,tiff|max:30000',
        ]);

        $accessory = new Accessory($request->all());

        if ($request->hasFile('picture_url')) {
            $accessory->picture_url = $request->file('picture_url')->store('picture_url', 'public');
        }

        $accessory->save();

        // Create initial stock record using polymorphic relationship
        $accessory->stocks()->create([
            'quantity' => $accessory->stock_quantity,
            'type' => 'initial',
        ]);

        return redirect()->route('accessories.index')->with('success', 'Accessory created successfully');
    }

    public function show($id)
    {
        $accessory = Accessory::findOrFail($id);
        return view('accessories.show', compact('accessory'));
    }

    public function edit($id)
    {
        $accessory = Accessory::findOrFail($id);
        $stocks = Stock::all();
        return view('accessories.edit', compact('accessory', 'stocks'));
    }

    public function update(Request $request, Accessory $accessory)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'brand' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'stock_quantity' => 'required|integer',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'picture_url' => 'nullable|image|mimes:jpg,jpeg,png,gif,bmp,tiff|max:30000',
        ]);

        $accessory->update($request->except('picture_url'));

        if ($request->hasFile('picture_url')) {
            if ($accessory->picture_url && Storage::exists('public/' . $accessory->picture_url)) {
                Storage::delete('public/' . $accessory->picture_url);
            }
            $accessory->picture_url = $request->file('picture_url')->store('picture_url', 'public');
            $accessory->save();
        }

        // Update or create stock record using polymorphic relationship
        $accessory->stocks()->updateOrCreate(
            [
                'stockable_id' => $accessory->id,
                'stockable_type' => Accessory::class,
                'type' => 'update'
            ],
            [
                'quantity' => $request->stock_quantity
            ]
        );

        return redirect()->route('accessories.index')->with('success', 'Accessory updated successfully');
    }

    public function destroy($id)
    {
        $accessory = Accessory::findOrFail($id);

        // Delete associated stock records
        $accessory->stocks()->delete();

        if ($accessory->picture_url) {
            Storage::delete('public/' . $accessory->picture_url);
        }

        $accessory->delete();

        return redirect()->route('accessories.index')->with('success', 'Accessory deleted successfully');
    }
}
