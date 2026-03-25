<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\GearOilChange;
use App\Http\Controllers\Controller;

class GearOilChangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch all gear oil changes associated with the authenticated user
        $gearOilChanges = GearOilChange::all();

        // Return the gear oil changes as a JSON response
        return response()->json([
            'status' => 'success',
            'data' => $gearOilChanges
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // This method can be used to show a form for creating a new gear oil change
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'record_id' => 'required|exists:maintenance_records,id',
            'oil_type' => 'required|string|max:255',
            'quantity' => 'required|numeric',
        ]);

        // Create a new gear oil change
        $gearOilChange = GearOilChange::create([
            'record_id' => $request->record_id,
            'oil_type' => $request->oil_type,
            'quantity' => $request->quantity,
        ]);

        // Return the created gear oil change as a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Gear oil change created successfully.',
            'data' => $gearOilChange
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Fetch the specified gear oil change by ID
        $gearOilChange = GearOilChange::findOrFail($id);

        // Return the gear oil change as a JSON response
        return response()->json([
            'status' => 'success',
            'data' => $gearOilChange
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'oil_type' => 'sometimes|required|string|max:255',
            'quantity' => 'sometimes|required|numeric',
        ]);

        // Fetch the gear oil change by ID
        $gearOilChange = GearOilChange::findOrFail($id);

        // Update the gear oil change with the validated data
        $gearOilChange->update($request->only(['oil_type', 'quantity']));

        // Return the updated gear oil change as a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Gear oil change updated successfully.',
            'data' => $gearOilChange
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Fetch the gear oil change by ID
        $gearOilChange = GearOilChange::findOrFail($id);

        // Delete the gear oil change
        $gearOilChange->delete();

        // Return a success response
        return response()->json([
            'status' => 'success',
            'message' => 'Gear oil change deleted successfully.'
        ]);
    }
}
