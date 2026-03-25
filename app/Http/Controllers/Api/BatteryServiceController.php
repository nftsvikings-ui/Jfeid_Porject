<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BatteryService;
use Illuminate\Http\Request;

class BatteryServiceController extends Controller
{
    /**
     * Display a listing of the battery services.
     */
    public function index(Request $request)
    {
        // Fetch all battery services associated with the authenticated user
        $batteryService = BatteryService::all();

        // Return the battery services as a JSON response
        return response()->json([
            'status' => 'success',
            'data' => $batteryService
        ]);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'record_id' => 'required|exists:maintenance_records,id',
            'brand' => 'required',
            'size' => 'required',
        ]);

        // Create a new battery service
        $batteryService = BatteryService::create([
            'record_id' => $request->record_id, // Ensure this ID exists in the maintenance_records table
            'brand' => $request->brand,
            'size' => $request->size,
        ]);

        // Return the created battery service as a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Battery service created successfully.',
            'data' => $batteryService
        ], 201);
    }
    /**
     * Display the specified battery service.
     */
    public function show($id)
    {
        // Fetch the battery service by ID
        $batteryService = BatteryService::find($id);

        if (!$batteryService) {
            return response()->json([
                'status' => 'error',
                'message' => 'Battery service not found.'
            ], 404);
        }

        // Return the battery service as a JSON response
        return response()->json([
            'status' => 'success',
            'data' => $batteryService
        ]);
    }
    /**
     * Show the form for editing the specified battery service.
     */
    public function edit($id)
    {
        $batteryService = BatteryService::find($id);
        if (!$batteryService) {
            return response()->json([
                'status' => 'error',
                'message' => 'Battery service not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $batteryService
        ]);
    }
    /**
     * Update the specified battery service in storage.
     */
    public function update(Request $request, $id)
    {
        // Fetch the battery service by ID
        $batteryService = BatteryService::find($id);
        // Validate the request data
        $request->validate([
            'brand' => 'required',
            'size' => 'required',
        ]);


        if (!$batteryService) {
            return response()->json([
                'status' => 'error',
                'message' => 'Battery service not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Battery service updated successfully.',
            'data' => $batteryService
        ]);
    }
    /**
     * Remove the specified battery service from storage.
     */
    public function destroy($id)
    {

        $batteryService = BatteryService::find($id);

        if (!$batteryService) {
            return response()->json([
                'status' => 'error',
                'message' => 'Battery service not found.'
            ], 404);
        }

        // Delete the battery service
        $batteryService->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Battery service deleted successfully.'
        ]);
    }
}
