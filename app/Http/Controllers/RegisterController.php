<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function registerread(Request $request)
    {
        // Handle GET request - show registration form
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('failed', 'Registration failed! Please check the errors below.');
        }

        try {
            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'fname' => null,
                'mname' => null,
                'lname' => null,
                'course' => null,
                'gender' => null,
                'role' => 'Athlete', // Default role
            ]);

            // Return to register form with success message
            return redirect()->route('register')->with('success', 'Registration successful! Please login to continue.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('failed', 'Registration failed. Please try again.');
        }
    }


}
