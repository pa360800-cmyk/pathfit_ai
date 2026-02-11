<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationNotification;

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
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            // Send denial email
            $fullName = trim($request->fname . ' ' . ($request->mname ? $request->mname . ' ' : '') . $request->lname);
            $tempUser = (object) [
                'name' => $fullName,
                'email' => $request->email,
            ];
            Mail::to($request->email)->send(new RegistrationNotification($tempUser, 'denied', 'Validation errors: ' . implode(', ', $validator->errors()->all())));

            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('failed', 'Registration failed! Please check the errors below.');
        }

        try {
            // Create the user
            $fullName = trim($request->fname . ' ' . ($request->mname ? $request->mname . ' ' : '') . $request->lname);
            $user = User::create([
                'name' => $fullName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'fname' => $request->fname,
                'mname' => $request->mname,
                'lname' => $request->lname,
                'course' => $request->course,
                'gender' => $request->gender,
                'role' => 'Athlete', // Default role
            ]);

            // Send success email
            Mail::to($user->email)->send(new RegistrationNotification($user, 'success'));

            // Return to register form with success message
            return redirect()->route('register')->with('success', 'Registration successful! Please login to continue.');
        } catch (\Exception $e) {
            // Send denial email on exception
            $fullName = trim($request->fname . ' ' . ($request->mname ? $request->mname . ' ' : '') . $request->lname);
            $tempUser = (object) [
                'name' => $fullName,
                'email' => $request->email,
            ];
            Mail::to($request->email)->send(new RegistrationNotification($tempUser, 'denied', 'An error occurred during registration: ' . $e->getMessage()));

            return redirect()->back()
                ->withInput()
                ->with('failed', 'Registration failed. Please try again.');
        }
    }


}
