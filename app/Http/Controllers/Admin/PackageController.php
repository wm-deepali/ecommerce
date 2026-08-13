<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;

class PackageController extends Controller
{
    // ✅ LIST
    public function index()
    {
        $packages = Package::with('features')->latest()->get();
        return view('admin.packages.index', compact('packages'));
    }

    // ✅ CREATE
    public function create()
    {
        if (Package::count() >= 3) {
            return redirect()->route('admin.packages.index')
                ->with('error', 'Only 3 packages allowed');
        }

        return view('admin.packages.create');
    }

    // ✅ STORE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric',
            'duration' => 'required|string',
            'features.*' => 'nullable|string|max:255'
        ]);

        if (Package::count() >= 3) {
            return back()->with('error', 'Only 3 packages allowed');
        }

        // ✅ FIX: checkbox handling
        $isPopular = $request->has('is_popular') ? 1 : 0;

        // ✅ only one popular
        if ($isPopular) {
            Package::where('is_popular', 1)->update(['is_popular' => 0]);
        }

        $package = Package::create([
            'name' => $request->name,
            'sub_title' => $request->sub_title,
            'cost' => $request->cost,
            'duration' => $request->duration,
            'button_text' => $request->button_text,
            'is_popular' => $isPopular,
        ]);

        // ✅ save features
        if ($request->features) {
            foreach ($request->features as $feature) {
                if (!empty(trim($feature))) {
                    $package->features()->create([
                        'feature_name' => $feature
                    ]);
                }
            }
        }

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package created successfully');
    }

    // ✅ EDIT
    public function edit($id)
    {
        $package = Package::with('features')->findOrFail($id);
        return view('admin.packages.edit', compact('package'));
    }

    // ✅ UPDATE
    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric',
            'duration' => 'required|string',
            'features.*' => 'nullable|string|max:255'
        ]);

        // ✅ FIX: checkbox handling
        $isPopular = $request->has('is_popular') ? 1 : 0;

        // ✅ only one popular
        if ($isPopular) {
            Package::where('is_popular', 1)
                ->where('id', '!=', $package->id)
                ->update(['is_popular' => 0]);
        }

        $package->update([
            'name' => $request->name,
            'sub_title' => $request->sub_title,
            'cost' => $request->cost,
            'duration' => $request->duration,
            'button_text' => $request->button_text,
            'is_popular' => $isPopular,
        ]);

        // ✅ reset features (clean approach)
        $package->features()->delete();

        if ($request->features) {
            foreach ($request->features as $feature) {
                if (!empty(trim($feature))) {
                    $package->features()->create([
                        'feature_name' => $feature
                    ]);
                }
            }
        }

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package updated successfully');
    }

    // ✅ DELETE
    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return response()->json([
            'message' => 'Package deleted successfully'
        ]);
    }
}