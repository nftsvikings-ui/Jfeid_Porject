<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TransmissionOilChange;
use Illuminate\Http\Request;

class TransmissionOilChangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $transmissionOilChanges = TransmissionOilChange::all(); 

        // Return the transmission oil change records as a JSON response
        return response()->json([
            'status' => 'success',
            'data' => $transmissionOilChanges
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // This method can be used to show a form for creating a new transmission oil change record
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'record_id' => 'required|exists:maintenance_records,id',
            'quantity' => 'required|numeric',
            'oil_type' => 'required|string|max:255',
        ]);

        // Create a new transmission oil change record
        $transmissionOilChange =TransmissionOilChange::create([
            'record_id' => $request->record_id,
            'quantity' => $request->quantity,
            'oil_type' => $request->oil_type,
        ]) ; 

        // Return the created transmission oil change record as a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Transmission oil change record created successfully.',
            'data' => $transmissionOilChange
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Fetch the transmission oil change record by ID
        $transmissionOilChange = TransmissionOilChange::findOrFail($id);

        // Return the transmission oil change record as a JSON response
        return response()->json([
            'status' => 'success',
            'data' => $transmissionOilChange
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'quantity' => 'sometimes|required|numeric',
            'oil_type' => 'sometimes|required|string|max:255',
        ]);

        // Fetch the transmission oil change record by ID
        $transmissionOilChange = TransmissionOilChange::findOrFail($id);

        // Update the transmission oil change record with the validated data
        $transmissionOilChange->update($request->only(['quantity', 'oil_type']));

        // Return the updated transmission oil change record as a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Transmission oil change record updated successfully.',
            'data' => $transmissionOilChange
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Fetch the transmission oil change record by ID
        $transmissionOilChange = TransmissionOilChange::findOrFail($id);

        // Delete the transmission oil change record
        $transmissionOilChange->delete();

        // Return a success response
        return response()->json([
            'status' => 'success',
            'message' => 'Transmission oil change record deleted successfully.'
        ]);
    }
}
