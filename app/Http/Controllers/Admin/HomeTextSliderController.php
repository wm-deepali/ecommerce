<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeTextSlider;
use Illuminate\Http\Request;

class HomeTextSliderController extends Controller
{
    public function index()
    {
        $items = HomeTextSlider::orderBy('sort_order')
            ->paginate(10);

        return view(
            'admin.home.text-sliders.index',
            compact('items')
        );
    }

    public function create()
    {
        return view(
            'admin.home.text-sliders.create'
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        HomeTextSlider::create([

            'title' => $request->title,

            'sort_order' => $request->sort_order ?? 0,

            'status' => $request->status ?? 1

        ]);

        return redirect()
            ->route('admin.home.text-sliders.index')
            ->with(
                'success',
                'Text slider added successfully.'
            );
    }

    public function edit($id)
    {
        $item = HomeTextSlider::findOrFail($id);

        return view(
            'admin.home.text-sliders.edit',
            compact('item')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $item = HomeTextSlider::findOrFail($id);

        $item->update([

            'title' => $request->title,

            'sort_order' => $request->sort_order ?? 0,

            'status' => $request->status ?? 1

        ]);

        return redirect()
            ->route('admin.home.text-sliders.index')
            ->with(
                'success',
                'Text slider updated successfully.'
            );
    }

    public function destroy($id)
    {
        HomeTextSlider::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}