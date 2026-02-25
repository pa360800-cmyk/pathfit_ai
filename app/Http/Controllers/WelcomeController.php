<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class WelcomeController extends Controller
{
    public function index()
    {
        try {
            $coaches = User::where('role', 'coach')
                ->take(4)
                ->get();

            return view('welcome', compact('coaches'));
        } catch (Exception $e) {
            // Log the error for debugging
            Log::error('WelcomeController error: ' . $e->getMessage());
            
            // Return view with empty coaches collection if database fails
            // This ensures the page still loads even if DB is unavailable
            return view('welcome', ['coaches' => collect([])]);
        }
    }
}
