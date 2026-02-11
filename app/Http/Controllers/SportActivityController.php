<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SportActivity;

class SportActivityController extends Controller
{
    public function index()
    {
        $sportActivities = SportActivity::all();
        return view('admin.sport-activity.index', compact('sportActivities'));
    }

    public function create()
    {
        // For now, return a simple view. You can add logic to create sport activities later.
        return view('admin.sport-activity.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Assuming SportActivity model exists, create the activity
        SportActivity::create($request->all());

        return redirect()->route('admin.sport_activity.index')->with('success', 'Sport activity created successfully');
    }

    public function edit($id)
    {
        $sportActivity = SportActivity::findOrFail($id);
        return view('admin.sport-activity.edit', compact('sportActivity'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $sportActivity = SportActivity::findOrFail($id);
        $sportActivity->update($request->all());

        return redirect()->route('admin.sport_activity.index')->with('success', 'Sport activity updated successfully');
    }

    public function destroy($id)
    {
        $sportActivity = SportActivity::findOrFail($id);
        $sportActivity->delete();

        return redirect()->route('admin.sport_activity.index')->with('success', 'Sport activity deleted successfully');
    }
}
