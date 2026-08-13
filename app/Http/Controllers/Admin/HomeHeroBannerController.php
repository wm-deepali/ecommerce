<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeHeroBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeHeroBannerController extends Controller
{
    public function index()
    {
        $items = HomeHeroBanner::orderBy('sort_order')
            ->paginate(20);

        return view(
            'admin.home-hero-banners.index',
            compact('items')
        );
    }

    public function create()
    {
        return view(
            'admin.home-hero-banners.create'
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'small_text' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'image' => 'required|image',
        ]);

        $image = null;

        if ($request->hasFile('image')) {

            $image = $request->file('image')
                ->store('hero-banners', 'public');
        }

        HomeHeroBanner::create([
            'small_text' => $request->small_text,
            'title' => $request->title,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'image' => $image,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.home-hero-banners.index')
            ->with('success', 'Hero banner added successfully.');
    }

    public function edit($id)
    {
        $item = HomeHeroBanner::findOrFail($id);

        return view(
            'admin.home-hero-banners.edit',
            compact('item')
        );
    }

    public function update(Request $request, $id)
    {
        $item = HomeHeroBanner::findOrFail($id);

        $image = $item->image;

        if ($request->hasFile('image')) {

            if (
                $item->image &&
                Storage::disk('public')->exists($item->image)
            ) {
                Storage::disk('public')->delete($item->image);
            }

            $image = $request->file('image')
                ->store('hero-banners', 'public');
        }

        $item->update([
            'small_text' => $request->small_text,
            'title' => $request->title,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'image' => $image,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.home-hero-banners.index')
            ->with('success', 'Hero banner updated successfully.');
    }

    public function destroy($id)
    {
        $item = HomeHeroBanner::findOrFail($id);

        if (
            $item->image &&
            Storage::disk('public')->exists($item->image)
        ) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return response()->json([
            'status' => true,
            'message' => 'Hero banner deleted successfully.'
        ]);
    }
}