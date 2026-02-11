<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $coaches = User::where('role', 'coach')->take(4)->get();

        return view('welcome', compact('coaches'));
    }
}
