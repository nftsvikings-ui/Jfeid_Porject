<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
 public function showResetForm(Request $request, $token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }
    // Handle the reset password POST request
    public function reset(Request $request)
    {
        // Validate inputs
        $validator = Validator::make($request->all(), [

       'password' => 'required|min:3',
            "confirm_password" => 'required|min:3',

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Attempt to reset the password using the Password broker
        $$status = Password::reset(
    $request->only('email', 'password'),
    function ($user, $password) {
        $user->password = Hash::make($password);
        $user->save();
    }
        );

        if ($status == Password::PASSWORD_RESET) {
            // Password reset success
            return redirect()->route('login')->with('status', __($status));
        } else {
            // Password reset failed
            return back()->withErrors(['email' => __($status)]);
        }
    }
}