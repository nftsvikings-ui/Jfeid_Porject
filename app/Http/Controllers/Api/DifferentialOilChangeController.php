<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DifferentialOilChange;
use Illuminate\Http\Request;

class DifferentialOilChangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch all differential oil change records associated with the authenticated user
        $differentialOilChanges = []; // Replace with actual fetching logic

        // Return the differential oil change records as a JSON response
        return response()->json([
            'status' => 'success',
            'data' => $differentialOilChanges
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // This method can be used to show a form for creating a new differential oil change record
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'record_id' => 'required|exists:maintenance_records,id',
            'quantity' => 'required',
            'oil_type' => 'required|string|max:255',
        ]);

        // Create a new differential oil change record
        $differentialOilChange = DifferentialOilChange::create([
            'record_id' => $request->record_id,
            'quantity' => $request->quantity,
            'oil_type' => $request->oil_type,
        ]); // Replace with actual creation logic

        // Return the created differential oil change record as a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Differential oil change record created successfully.',
            'data' => $differentialOilChange
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the differential oil change record by ID
        $differentialOilChange = DifferentialOilChange::findOrFail($id); // Replace with actual fetching logic

        // Return the differential oil change record as a JSON response
        return response()->json([
            'status' => 'success',
            'data' => $differentialOilChange
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // This method can be used to show a form for editing the specified differential oil change record
        // You can implement the logic to fetch the record and return it for editing
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $request->validate([
            'quantity' => 'required',
            'oil_type' => 'required|string|max:255',
        ]);

        // Find the differential oil change record by ID
        $differentialOilChange = DifferentialOilChange::findOrFail($id); // Replace with actual fetching logic

        // Update the record with the new data
        $differentialOilChange->update([
            'quantity' => $request->quantity,
            'oil_type' => $request->oil_type,
        ]);

        // Return the updated differential oil change record as a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Differential oil change record updated successfully.',
            'data' => $differentialOilChange
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the differential oil change record by ID
        $differentialOilChange = DifferentialOilChange::findOrFail($id); // Replace with actual fetching logic

        // Delete the record
        $differentialOilChange->delete();

        // Return a success response
        return response()->json([
            'status' => 'success',
            'message' => 'Differential oil change record deleted successfully.'
        ]);
    }
}
