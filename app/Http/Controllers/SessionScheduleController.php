<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SessionSchedule;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SessionScheduleController extends Controller
{
    public function coachIndex()
    {
        $sessionSchedules = SessionSchedule::where('coach_id', auth()->id())->with('athlete')->get();
        return view('coach.session-schedules.index', compact('sessionSchedules'));
    }

    public function coachCreate()
    {
        // Ensure only coaches can access this
        if (auth()->user()->role !== 'Coach') {
            abort(403, 'Unauthorized');
        }

        $athletes = auth()->user()->athletes;
        return view('coach.session-schedules.create', compact('athletes'));
    }

    public function coachStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'athlete_id' => 'required|exists:users,id',
            'session_date' => 'required|date',
            'session_time' => 'required|date_format:H:i',
            'duration' => 'required|integer|min:15|max:240',
            'status' => 'required|in:scheduled,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Calculate end_time from start_time and duration
        $startTime = Carbon::createFromFormat('H:i', $request->session_time);
        $endTime = $startTime->copy()->addMinutes((int) $request->duration);

        SessionSchedule::create([
            'title' => $request->title,
            'athlete_id' => $request->athlete_id,
            'date' => $request->session_date,
            'start_time' => $request->session_time,
            'end_time' => $endTime->format('H:i'),
            'duration' => $request->duration,
            'status' => $request->status,
            'notes' => $request->notes,
            'coach_id' => auth()->id(),
        ]);

        return redirect()->route('coach.session-schedules.index')->with('success', 'Session schedule created successfully');
    }

    public function coachShow(SessionSchedule $sessionSchedule)
    {
        // Ensure the session schedule belongs to the authenticated coach
        if ($sessionSchedule->coach_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('coach.session-schedules.show', compact('sessionSchedule'));
    }

    public function coachEdit(SessionSchedule $sessionSchedule)
    {
        // Ensure the session schedule belongs to the authenticated coach
        if ($sessionSchedule->coach_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('coach.session-schedules.edit', compact('sessionSchedule'));
    }

    public function coachUpdate(Request $request, SessionSchedule $sessionSchedule)
    {
        // Ensure the session schedule belongs to the authenticated coach
        if ($sessionSchedule->coach_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $sessionSchedule->update([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('coach.session-schedules.index')->with('success', 'Session schedule updated successfully');
    }

    public function coachDestroy(SessionSchedule $sessionSchedule)
    {
        // Ensure the session schedule belongs to the authenticated coach
        if ($sessionSchedule->coach_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $sessionSchedule->delete();
        return redirect()->route('coach.session-schedules.index')->with('success', 'Session schedule deleted successfully');
    }

    public function athleteIndex()
    {
        $sessionSchedules = SessionSchedule::where('athlete_id', auth()->id())->with('coach')->get();
        return view('athlete.session-schedules.index', compact('sessionSchedules'));
    }
}
