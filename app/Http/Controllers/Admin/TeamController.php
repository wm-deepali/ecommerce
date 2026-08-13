<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    // ✅ LIST
    public function index()
    {
        $teams = Team::latest()->get();
        return view('admin.teams.index', compact('teams'));
    }

    // ✅ CREATE
    public function create()
    {
        return view('admin.teams.create');
    }

    // ✅ STORE
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'status' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('teams', 'public');
        }

        $data['status'] = $request->has('status') ? 1 : 0;

        Team::create($data);

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team member added successfully');
    }

    // ✅ EDIT
    public function edit($id)
    {
        $team = Team::findOrFail($id);
        return view('admin.teams.edit', compact('team'));
    }

    // ✅ UPDATE
    public function update(Request $request, $id)
    {
        $team = Team::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'status' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('teams', 'public');
        }

        $data['status'] = $request->has('status') ? 1 : 0;

        $team->update($data);

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team updated successfully');
    }

    // ✅ DELETE
    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}