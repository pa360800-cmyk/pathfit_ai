<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SportAvailable;

class SportAvailableController extends Controller
{
    public function index()
    {
        $sportAvailables = SportAvailable::all();
        return view('admin.sport-available.index', compact('sportAvailables'));
    }

    public function create()
    {
        return view('admin.sport-available.create');
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

        SportAvailable::create($request->all());

        return redirect()->route('admin.sport_available.index')->with('success', 'Sport available created successfully');
    }

    public function edit($id)
    {
        $sportAvailable = SportAvailable::findOrFail($id);
        return view('admin.sport-available.edit', compact('sportAvailable'));
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

        $sportAvailable = SportAvailable::findOrFail($id);
        $sportAvailable->update($request->all());

        return redirect()->route('admin.sport_available.index')->with('success', 'Sport available updated successfully');
    }

    public function destroy($id)
    {
        $sportAvailable = SportAvailable::findOrFail($id);
        $sportAvailable->delete();

        return redirect()->route('admin.sport_available.index')->with('success', 'Sport available deleted successfully');
    }
}
