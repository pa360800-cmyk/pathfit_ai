<?php

namespace App\Http\Controllers;

use App\Models\Event;

class AthleteEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with('creator')->get();
        return view('athlete.events.index', compact('events'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('athlete.events.show', compact('event'));
    }
}
