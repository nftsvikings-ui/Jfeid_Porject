<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SteeringOilChange;
use App\Http\Controllers\Controller;

class SteeringOilChangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch all steering oil changes associated with the authenticated user
        $steeringOilChanges = SteeringOilChange::all();

        // Return the steering oil changes as a JSON response
        return response()->json([
            'status' => 'success',
            'data' => $steeringOilChanges
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // This method can be used to show a form for creating a new steering oil change
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
            'quantity' => 'required',
        ]);

        // Create a new steering oil change
        $steeringOilChange = SteeringOilChange::create([
            'record_id' => $request->record_id,
            'oil_type' => $request->oil_type,
            'quantity' => $request->quantity,
        ]);

        // Return the created steering oil change as a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Steering oil change created successfully.',
            'data' => $steeringOilChange
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Fetch the steering oil change by ID
        $steeringOilChange = SteeringOilChange::findOrFail($id);

        // Return the steering oil change as a JSON response
        return response()->json([
            'status' => 'success',
            'data' => $steeringOilChange
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

        // Fetch the steering oil change by ID
        $steeringOilChange = SteeringOilChange::findOrFail($id);

        // Update the steering oil change with the validated data
        $steeringOilChange->update($request->only(['oil_type', 'quantity']));

        // Return the updated steering oil change as a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Steering oil change updated successfully.',
            'data' => $steeringOilChange
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Fetch the steering oil change by ID
        $steeringOilChange = SteeringOilChange::findOrFail($id);

        // Delete the steering oil change
        $steeringOilChange->delete();

        // Return a success response
        return response()->json([
            'status' => 'success',
            'message' => 'Steering oil change deleted successfully.'
        ]);
    }
  
}
