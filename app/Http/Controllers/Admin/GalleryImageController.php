<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryImageController extends Controller
{
    public function index()
    {
        $galleryImages = GalleryImage::orderBy('column_no')
            ->orderBy('sort_order')
            ->latest()
            ->paginate(10);

        return view(
            'admin.gallery-images.index',
            compact('galleryImages')
        );
    }

    public function create()
    {
        return view('admin.gallery-images.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'nullable|string|max:255',
            'image'        => 'required|image|mimes:jpg,jpeg,png,webp',
            'column_no'    => 'required|in:1,2,3',
            'height_class' => 'required|in:h-sm,h-md,h-lg,h-xl',
            'sort_order'   => 'nullable|integer',
        ]);

        $image = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image')
                ->store('gallery', 'public');
        }

        GalleryImage::create([
            'title'        => $request->title,
            'image'        => $image,
            'column_no'    => $request->column_no,
            'height_class' => $request->height_class,
            'sort_order'   => $request->sort_order ?? 0,
            'status'       => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.gallery-images.index')
            ->with('success', 'Gallery image added successfully.');
    }

    public function edit($id)
    {
        $galleryImage = GalleryImage::findOrFail($id);

        return view(
            'admin.gallery-images.edit',
            compact('galleryImage')
        );
    }

    public function update(Request $request, $id)
    {
        $galleryImage = GalleryImage::findOrFail($id);

        $request->validate([
            'title'        => 'nullable|string|max:255',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'column_no'    => 'required|in:1,2,3',
            'height_class' => 'required|in:h-sm,h-md,h-lg,h-xl',
            'sort_order'   => 'nullable|integer',
        ]);

        $image = $galleryImage->image;

        if ($request->hasFile('image')) {

            if (
                $galleryImage->image &&
                Storage::disk('public')->exists($galleryImage->image)
            ) {
                Storage::disk('public')
                    ->delete($galleryImage->image);
            }

            $image = $request->file('image')
                ->store('gallery', 'public');
        }

        $galleryImage->update([
            'title'        => $request->title,
            'image'        => $image,
            'column_no'    => $request->column_no,
            'height_class' => $request->height_class,
            'sort_order'   => $request->sort_order ?? 0,
            'status'       => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.gallery-images.index')
            ->with('success', 'Gallery image updated successfully.');
    }

    public function destroy($id)
    {
        $galleryImage = GalleryImage::findOrFail($id);

        if (
            $galleryImage->image &&
            Storage::disk('public')->exists($galleryImage->image)
        ) {
            Storage::disk('public')
                ->delete($galleryImage->image);
        }

        $galleryImage->delete();

        return redirect()
            ->route('admin.gallery-images.index')
            ->with('success', 'Gallery image deleted successfully.');
    }
}