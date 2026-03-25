<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signup(Request $request)
    {

        // validate data from user
        $request->validate([
            "name" => "required|string",
            "email" => "email|unique:users",
            "phonenumber" => "required|string",
            "password" => "required|min:3",
            "carplate" => "nullable|string",
        ]);

        // create new user and save it to database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phonenumber' => $request->phonenumber,
            'password' => Hash::make($request->password),
            'carplate' => $request->carplate,
        ]);


        // Check if the request is coming from a Flutter application
        if ($request->header('User-Agent') === 'Flutter') {
            $access_token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status' => '201',
                'message' => 'User has been created successfully.',
                'token' => $access_token
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'invalid request'
            ]);
        }
    }
    public function signin(Request $request)
    {
        Log::info('Login request received', ['request' => $request->all()]);

        $credentials = $request->validate([
            'name_or_email' => 'required|string',
            'password' => 'required|string|min:3',
        ]);

        $user = User::where('email', $credentials['name_or_email'])
            ->orWhere('name', $credentials['name_or_email'])
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $access_token = $user->createToken("authToken")->plainTextToken;

            // get first vehicle id
            $vehicle_id = $user->vehicles()->first()?->id;

            return response()->json([
                'success' => true,
                'message' => 'Logged In Successfully!',
                'vehicle_id' => $vehicle_id,
                'token' => $access_token
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Username/Email or Password'
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }
    public function getProfile(Request $request)
    {
        // Return the authenticated user's profile
        return response()->json([
            'status' => 'success',
            'data' => $request->user()
        ]);
    }
    public function destroy(Request $request)
    {
        $user = \App\Models\User::find(Auth::id());

        if ($user) {
            // Optionally revoke tokens if using Sanctum
            if (method_exists($user, 'tokens')) {
                $user->tokens()->delete();
            }

            // Delete the user
            $user->delete();

            return response()->json(['message' => 'User deleted successfully.'], 200);
        }

        return response()->json(['error' => 'User not found.'], 404);
    }
}
