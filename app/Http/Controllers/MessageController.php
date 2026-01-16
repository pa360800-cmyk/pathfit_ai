<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\SportRequirement;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display the messaging interface with contacts
     */
    public function index()
    {
        $user = Auth::user();

        // Get contacts based on user role
        if ($user->role === 'Athlete') {
            // Athletes can message their coach
            $contacts = User::where('id', $user->coach_id)->get();
        } elseif ($user->role === 'Coach') {
            // Coaches can message their athletes
            $contacts = User::where('coach_id', $user->id)->where('role', 'Athlete')->get();
        } else {
            // Admin or other roles - no contacts for now
            $contacts = collect();
        }

        // Get latest messages for each contact
        $contactsWithMessages = $contacts->map(function ($contact) use ($user) {
            $latestMessage = Message::where(function ($query) use ($user, $contact) {
                $query->where('sender_id', $user->id)->where('receiver_id', $contact->id);
            })->orWhere(function ($query) use ($user, $contact) {
                $query->where('sender_id', $contact->id)->where('receiver_id', $user->id);
            })->latest()->first();

            $unreadCount = Message::where('sender_id', $contact->id)
                ->where('receiver_id', $user->id)
                ->where('is_read', false)
                ->count();

            return [
                'contact' => $contact,
                'latest_message' => $latestMessage,
                'unread_count' => $unreadCount,
            ];
        });

        return view('messages.index', compact('contactsWithMessages'));
    }

    /**
     * Display the messaging interface for athletes
     */
    public function athleteIndex()
    {
        $user = Auth::user();

        // Get contacts based on user role
        if ($user->role === 'Athlete') {
            // Athletes can message their coach
            $contacts = User::where('id', $user->coach_id)->get();
        } else {
            // Fallback for other roles
            $contacts = collect();
        }

        // Get latest messages for each contact
        $contactsWithMessages = $contacts->map(function ($contact) use ($user) {
            $latestMessage = Message::where(function ($query) use ($user, $contact) {
                $query->where('sender_id', $user->id)->where('receiver_id', $contact->id);
            })->orWhere(function ($query) use ($user, $contact) {
                $query->where('sender_id', $contact->id)->where('receiver_id', $user->id);
            })->latest()->first();

            $unreadCount = Message::where('sender_id', $contact->id)
                ->where('receiver_id', $user->id)
                ->where('is_read', false)
                ->count();

            return [
                'contact' => $contact,
                'latest_message' => $latestMessage,
                'unread_count' => $unreadCount,
            ];
        });

        return view('athlete.messages.index', compact('contactsWithMessages'));
    }

    /**
     * Display the messaging interface for coaches
     */
    public function coachIndex()
    {
        $user = Auth::user();

        // Get contacts based on user role
        if ($user->role === 'Coach') {
            // Coaches can message their athletes
            $contacts = User::where('coach_id', $user->id)->where('role', 'Athlete')->get();
        } else {
            // Fallback for other roles
            $contacts = collect();
        }

        // Get latest messages for each contact
        $contactsWithMessages = $contacts->map(function ($contact) use ($user) {
            $latestMessage = Message::where(function ($query) use ($user, $contact) {
                $query->where('sender_id', $user->id)->where('receiver_id', $contact->id);
            })->orWhere(function ($query) use ($user, $contact) {
                $query->where('sender_id', $contact->id)->where('receiver_id', $user->id);
            })->latest()->first();

            $unreadCount = Message::where('sender_id', $contact->id)
                ->where('receiver_id', $user->id)
                ->where('is_read', false)
                ->count();

            return [
                'contact' => $contact,
                'latest_message' => $latestMessage,
                'unread_count' => $unreadCount,
            ];
        });

        return view('coach.messages.index', compact('contactsWithMessages'));
    }

    /**
     * Display conversation with a specific contact
     */
    public function show(User $contact)
    {
        $user = Auth::user();

        // Mark messages as read
        Message::where('sender_id', $contact->id)
            ->where('receiver_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Get conversation messages
        $messages = Message::where(function ($query) use ($user, $contact) {
            $query->where('sender_id', $user->id)->where('receiver_id', $contact->id);
        })->orWhere(function ($query) use ($user, $contact) {
            $query->where('sender_id', $contact->id)->where('receiver_id', $user->id);
        })->orderBy('created_at', 'asc')->get();

        // Return appropriate view based on user role
        if ($user->role === 'Athlete') {
            return view('athlete.messages.show', compact('contact', 'messages'));
        } elseif ($user->role === 'Coach') {
            return view('coach.messages.show', compact('contact', 'messages'));
        } else {
            // Fallback for admin/other roles
            return view('messages.show', compact('contact', 'messages'));
        }
    }

    /**
     * Store a new message
     */
    public function store(Request $request, User $contact)
    {
        $user = Auth::user();

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $contact->id,
            'content' => $request->content,
            'is_read' => false,
        ]);

        return redirect()->route('messages.show', $contact)->with('success', 'Message sent successfully!');
    }

    /**
     * Store a new message for coaches
     */
    public function coachStore(Request $request, User $contact)
    {
        $user = Auth::user();

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $contact->id,
            'content' => $request->content,
            'is_read' => false,
        ]);

        return redirect()->route('coach.messages.show', $contact)->with('success', 'Message sent successfully!');
    }

    /**
     * Store a new message for athletes
     */
    public function athleteStore(Request $request, User $contact)
    {
        $user = Auth::user();

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $contact->id,
            'content' => $request->content,
            'is_read' => false,
        ]);

        return redirect()->route('athlete.messages.show', $contact)->with('success', 'Message sent successfully!');
    }



    /**
     * Redirect to message page for the coach assigned to a specific sport
     */
    public function contactSportCoach($sportId)
    {
        $user = Auth::user();

        // Only athletes can use this feature
        if ($user->role !== 'Athlete') {
            abort(403, 'This feature is only available for athletes.');
        }

        // Find the coach assigned to this sport
        $sportRequirement = SportRequirement::where('sport_available_id', $sportId)
            ->where('is_active', true)
            ->first();

        if (!$sportRequirement) {
            return redirect()->route('messages.index')->with('error', 'No coach is currently assigned to this sport.');
        }

        $coach = User::find($sportRequirement->coach_id);

        if (!$coach || $coach->role !== 'Coach') {
            return redirect()->route('messages.index')->with('error', 'The assigned coach for this sport is not available.');
        }

        // Set the athlete's primary sport when they contact a coach
        $sport = \App\Models\SportAvailable::find($sportId);
        if ($sport) {
            $user->primary_sport = $sport->name;
            $user->coach_id = $coach->id; // Also assign the coach
            $user->save();
        }

        // Redirect to the message page with this coach
        return redirect()->route('messages.show', $coach)->with('success', 'You have successfully selected ' . $sport->name . ' as your primary sport and contacted your coach!');
    }
}
