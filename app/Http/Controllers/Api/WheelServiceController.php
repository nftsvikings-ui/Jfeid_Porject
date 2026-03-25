<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WheelService;
use Illuminate\Http\Request;

class WheelServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch all wheel services associated with the authenticated user
        $wheelServices = WheelService::all(); // Replace with actual logic to fetch wheel services

        // Return the wheel services as a JSON response
        return response()->json([
            'status' => 'success',
            'data' => $wheelServices
        ]);     
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // This method can be used to show a form for creating a new wheel service
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'record_id' => 'required|exists:maintenance_records,id',
            'wheel_name' => 'required|string|max:255',
            'quantity' => 'required',
            'wheel_size' => 'required|string|max:50',
        ]);

        // Create a new wheel service
        $wheelService = WheelService::create([
            'record_id' => $request->record_id,
            'wheel_name' => $request->wheel_name,
            'quantity' => $request->quantity,
            'wheel_size' => $request->wheel_size,
        ]); 

        // Return the created wheel service as a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Wheel service created successfully.',
            'data' => $wheelService
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Fetch the wheel service by ID
        $wheelService = WheelService::findOrFail($id);

        // Return the wheel service as a JSON response
        return response()->json([
            'status' => 'success',
            'data' => $wheelService
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)           
    {
        // This method can be used to show a form for editing the specified wheel service
        // Typically, you would fetch the wheel service by ID and return it to the view
        $wheelService = WheelService::findOrFail($id);
        
        return response()->json([
            'status' => 'success',
            'data' => $wheelService
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'wheel_name' => 'required|string|max:255',
            'quantity' => 'required',
            'wheel_size' => 'required|string|max:50',
        ]);

        // Fetch the wheel service by ID
        $wheelService = WheelService::findOrFail($id);

        // Update the wheel service with the validated data
        $wheelService->update([
            'wheel_name' => $request->wheel_name,
            'quantity' => $request->quantity,
            'wheel_size' => $request->wheel_size,
        ]);

        // Return the updated wheel service as a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Wheel service updated successfully.',
            'data' => $wheelService
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Fetch the wheel service by ID
        $wheelService = WheelService::findOrFail($id);

        // Delete the wheel service
        $wheelService->delete();

        // Return a success response
        return response()->json([
            'status' => 'success',
            'message' => 'Wheel service deleted successfully.'
        ]);
    }
}
