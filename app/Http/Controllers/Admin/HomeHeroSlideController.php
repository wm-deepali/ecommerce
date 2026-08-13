<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeHeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeHeroSlideController extends Controller
{
    public function index()
    {
        $items = HomeHeroSlide::orderBy('sort_order')
            ->paginate(20);

        return view(
            'admin.home-hero-slides.index',
            compact('items')
        );
    }

    public function create()
    {
        return view(
            'admin.home-hero-slides.create'
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'subtitle' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'image' => 'required|image',
        ]);

        $image = null;

        if ($request->hasFile('image')) {

            $image = $request->file('image')
                ->store('hero-slides', 'public');
        }

        HomeHeroSlide::create([
            'subtitle' => $request->subtitle,
            'title' => $request->title,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'image' => $image,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.home-hero-slides.index')
            ->with('success', 'Hero slide added successfully.');
    }

    public function edit($id)
    {
        $item = HomeHeroSlide::findOrFail($id);

        return view(
            'admin.home-hero-slides.edit',
            compact('item')
        );
    }

    public function update(Request $request, $id)
    {
        $item = HomeHeroSlide::findOrFail($id);

        $image = $item->image;

        if ($request->hasFile('image')) {

            if (
                $item->image &&
                Storage::disk('public')->exists($item->image)
            ) {
                Storage::disk('public')->delete($item->image);
            }

            $image = $request->file('image')
                ->store('hero-slides', 'public');
        }

        $item->update([
            'subtitle' => $request->subtitle,
            'title' => $request->title,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'image' => $image,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.home-hero-slides.index')
            ->with('success', 'Hero slide updated successfully.');
    }

    public function destroy($id)
    {
        $item = HomeHeroSlide::findOrFail($id);

        if (
            $item->image &&
            Storage::disk('public')->exists($item->image)
        ) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return response()->json([
            'status' => true,
            'message' => 'Hero slide deleted successfully.'
        ]);
    }
}