<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Award;
use Illuminate\Support\Facades\Validator;

class AwardController extends Controller
{
    // ✅ LIST
    public function index()
    {
        $awards = Award::latest()->get();
        return view('admin.awards.index', compact('awards'));
    }

    // ✅ CREATE FORM
    public function create()
    {
        return view('admin.awards.create');
    }

    // ✅ STORE
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'year' => 'required|digits:4',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'status' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('awards', 'public');
        }

        $data['status'] = $request->has('status') ? 1 : 0;

        Award::create($data);

        return redirect()->route('admin.awards.index')
            ->with('success', 'Award created successfully');
    }
    // ✅ EDIT FORM
    public function edit($id)
    {
        $award = Award::findOrFail($id);
        return view('admin.awards.edit', compact('award'));
    }

    // ✅ UPDATE
    public function update(Request $request, $id)
    {
        $award = Award::findOrFail($id);


        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'year' => 'required|digits:4',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'status' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();


        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('awards', 'public');
        }

        $data['status'] = $request->has('status') ? 1 : 0;

        $award->update($data);

        return redirect()->route('admin.awards.index')
            ->with('success', 'Award updated successfully');
    }

    // ✅ DELETE
    public function destroy($id)
    {
        $award = Award::findOrFail($id);

        if ($award->image && \Storage::disk('public')->exists($award->image)) {
            \Storage::disk('public')->delete($award->image);
        }

        $award->delete();

        return redirect()->route('admin.awards.index')
            ->with('success', 'Award deleted successfully');
    }
}