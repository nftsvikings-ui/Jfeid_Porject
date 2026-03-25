<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        
        // Return the authenticated user's profile
        return response()->json([
            'status' => 'success',
            'data' => $request->user()
        ]);
    }

    public function updateProfile(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255|unique:users,email,' . $request->user()->id,
            'Phonenumber' => 'sometimes|string|max:15',
            'carplate' => 'sometimes|string|max:20',
        ]);

        // Update the user's profile
        $user = $request->user();
        $user->update($request->only('name', 'email', 'Phonenumber' ));

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully.',
            'data' => $user
        ]);
    }
    public function changePassword(Request $request)
    {
        // Validate the request data
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Check if the current password is correct
        if (!Hash::check($request->current_password, $request->user()->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Current password is incorrect.'
            ], 403);
        }

        // Update the user's password
        $user = $request->user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Password changed successfully.'
        ]);
    }
}
