<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ticket = ticket::all();
        return response()->json(["data" => $ticket]);
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'match_name' => 'required|string|max:255',
            'stadium' => 'required|string|max:255',
            'match_date' => 'required|date',
            'zoon_seats' => 'required|integer|min:1',
            'zoon_price' => 'required|numeric|min:0',
            'status' => 'required|in:available,sold_out,cancelled',
            'picture_url' => 'image|nullable|mimes:jpg,jpeg,png,gif,bmp,tiff|max:9999'
        ]);

        if (isset($validated['match_date'])) {
            $validated['match_date'] = \Carbon\Carbon::parse($validated['match_date'])->format('Y-m-d H:i:s');
        }
        if ($request->hasFile('picture_url')) {
            $validated['picture_url'] = $request->file('picture_url')->store('tickets', 'public');
        }

        $ticket = Ticket::create($validated);

        return response()->json([
            "success" => true,
            "data" => $ticket
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
