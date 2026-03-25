<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PasswordResetToken;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token)
    {
        return view('password.reset', ['token' => $token]);
    }
    public function reset(Request $request, $token)
    {
        $request->validate([
             'email' => 'required|email',
    'password' => 'required|min:3|confirmed',
            'token' => 'required|string',
        ]);

        // Retrieve email based on the token
        $passwordResetToken = PasswordResetToken::where('token', $token)->first();

        if (!$passwordResetToken) {
            throw \Illuminate\Validation\ValidationException::withMessages(['error' => 'Invalid or expired token']);
        }

        // Retrieve user based on the email
        $user = User::where('email', $passwordResetToken->email)->first();

        if (!$user) {
            throw \Illuminate\Validation\ValidationException::withMessages(['error' => 'User not found']);
        }

        // Reset user's password
        $user->password = Hash::make($request->password);
        if ($request->password !== $request->confirm_password) {
            throw \Illuminate\Validation\ValidationException::withMessages(['error' => 'Passwords do not match']);
        }
        $user->save();

        // Delete the password reset token
        $passwordResetToken->delete();

        return response()->json(['message' => 'Password has been reset successfully']);
    }
}
