<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReturnReason;
use Illuminate\Http\Request;

class ReturnReasonController extends Controller
{
    public function index()
    {
        $reasons = ReturnReason::orderBy('sort_order')->orderBy('id')->paginate(20);
        return view('admin.return-reasons.index', compact('reasons'));
    }

    public function create()
    {
        return view('admin.return-reasons.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:255',
            'is_active'  => 'required|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;

        ReturnReason::create($data);

        return redirect()->route('admin.return-reasons.index')
            ->with('success', 'Return reason created.');
    }

    public function edit(ReturnReason $returnReason)
    {
        return view('admin.return-reasons.edit', compact('returnReason'));
    }

    public function update(Request $request, ReturnReason $returnReason)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:255',
            'is_active'  => 'required|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;

        $returnReason->update($data);

        $redirect = $request->input('redirect', route('admin.return-reasons.index'));

        return redirect($redirect)->with('success', 'Return reason updated.');
    }

    public function destroy(ReturnReason $returnReason)
    {
        $returnReason->delete();

        return redirect()->route('admin.return-reasons.index')
            ->with('success', 'Return reason deleted.');
    }
}