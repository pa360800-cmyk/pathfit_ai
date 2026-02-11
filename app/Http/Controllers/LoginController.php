<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Redirect based on role
            switch ($user->role) {
                case 'Administrator':
                    return redirect()->route('admin.dashboard')->with('success', 'Welcome Administrator!');
                case 'Athlete':
                    return redirect()->route('athlete.dashboard')->with('success', 'Welcome Athlete!');
                case 'Coach':
                    return redirect()->route('coach.dashboard')->with('success', 'Welcome Coach!');
                default:
                    Auth::logout();
                    return redirect()->back()->with('error', 'Unauthorized role.');
            }
        }

        return redirect()->back()->with('error', 'Invalid credentials.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logged out successfully.');
    }
}
