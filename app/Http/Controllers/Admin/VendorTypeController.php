<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VendorType;
use Illuminate\Http\Request;

class VendorTypeController extends Controller
{
    public function index()
    {
        $types = VendorType::latest()->paginate(10);
        return view('admin.vendor-types.index', compact('types'));
    }

    public function create()
    {
        return view('admin.vendor-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);

        VendorType::create($request->all());

        return redirect()->route('admin.vendor-types.index')
            ->with('success', 'Vendor Type created successfully');
    }

    public function edit($id)
    {
        $type = VendorType::findOrFail($id);
        return view('admin.vendor-types.edit', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);

        $type = VendorType::findOrFail($id);
        $type->update($request->all());

        return redirect()->route('admin.vendor-types.index')
            ->with('success', 'Updated successfully');
    }

      public function destroy($id)
    {
        VendorType::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully'
        ]);
    }
}