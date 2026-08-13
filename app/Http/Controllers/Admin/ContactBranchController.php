<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactBranch;
use Illuminate\Support\Facades\Storage;

class ContactBranchController extends Controller
{
    /*
    |--------------------------------------------------
    | INDEX
    |--------------------------------------------------
    */
    public function index()
    {
        $branches = ContactBranch::latest()->paginate(10);
        return view('admin.contact-branches.index', compact('branches'));
    }

    /*
    |--------------------------------------------------
    | CREATE
    |--------------------------------------------------
    */
    public function create()
    {
        return view('admin.contact-branches.create');
    }

    /*
    |--------------------------------------------------
    | STORE (ADD MORE SUPPORT 🔥)
    |--------------------------------------------------
    */
    public function store(Request $request)
    {
        if ($request->title) {

            foreach ($request->title as $key => $title) {

                $icon = null;

                if (isset($request->icon[$key]) && $request->icon[$key]) {
                    $icon = $request->file('icon')[$key]->store('branches', 'public');
                }

                ContactBranch::create([
                    'title' => $title,
                    'address' => $request->address[$key] ?? null,
                    'phone' => $request->phone[$key] ?? null,
                    'email' => $request->email[$key] ?? null,
                    'working_hours' => $request->working_hours[$key] ?? null,
                    'icon' => $icon,
                    'status' => 1
                ]);
            }
        }

        return redirect()->route('admin.contact-branches.index')
            ->with('success', 'Branches Added Successfully');
    }

    /*
    |--------------------------------------------------
    | EDIT
    |--------------------------------------------------
    */
    public function edit($id)
    {
        $branch = ContactBranch::findOrFail($id);
        return view('admin.contact-branches.edit', compact('branch'));
    }

    /*
    |--------------------------------------------------
    | UPDATE
    |--------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $branch = ContactBranch::findOrFail($id);

        $icon = $branch->icon;

        if ($request->hasFile('icon')) {

            // delete old
            if ($branch->icon && Storage::disk('public')->exists($branch->icon)) {
                Storage::disk('public')->delete($branch->icon);
            }

            // upload new
            $icon = $request->file('icon')->store('branches', 'public');
        }

        $branch->update([
            'title' => $request->title,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'working_hours' => $request->working_hours,
            'icon' => $icon,
            'status' => $request->status ?? 1
        ]);

        return redirect()->route('admin.contact-branches.index')
            ->with('success', 'Branch Updated Successfully');
    }

    /*
    |--------------------------------------------------
    | DELETE
    |--------------------------------------------------
    */
    public function destroy($id)
    {
        $branch = ContactBranch::findOrFail($id);

        // delete icon
        if ($branch->icon && Storage::disk('public')->exists($branch->icon)) {
            Storage::disk('public')->delete($branch->icon);
        }

        $branch->delete();

        return response()->json([
            'message' => 'Deleted Successfully'
        ]);
    }
}