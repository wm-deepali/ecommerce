<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customization;

class CustomizationController extends Controller
{
    // LIST
    public function index()
    {
        $customizations = Customization::latest()->paginate(10);
        return view('admin.customizations.index', compact('customizations'));
    }

    // CREATE FORM
    public function create()
    {
        return view('admin.customizations.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Customization::create([
            'name' => $request->name,
            'short_description' => $request->short_description,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('admin.customizations.index')
            ->with('success', 'Customization created successfully');
    }

    // EDIT
    public function edit($id)
    {
        $customization = Customization::findOrFail($id);
        return view('admin.customizations.edit', compact('customization'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $customization = Customization::findOrFail($id);

        $customization->update([
            'name' => $request->name,
            'short_description' => $request->short_description,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('admin.customizations.index')
            ->with('success', 'Customization updated successfully');
    }

    // DELETE
    public function destroy($id)
    {
        $customization = Customization::findOrFail($id);
        $customization->delete();

        return back()->with('success', 'Customization deleted');
    }
}