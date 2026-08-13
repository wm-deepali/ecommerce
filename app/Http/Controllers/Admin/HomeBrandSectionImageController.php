<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBrandSection;
use App\Models\HomeBrandSectionImage;
use App\Traits\CompressesImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeBrandSectionImageController extends Controller
{
    use CompressesImages;

    public function index()
    {
        $items = HomeBrandSectionImage::latest()
            ->paginate(20);

        return view(
            'admin.home.brand-section-images.index',
            compact('items')
        );
    }

    public function create()
    {
        $sections = HomeBrandSection::where('status', 1)->get();

        return view(
            'admin.home.brand-section-images.create',
            compact('sections')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp',
            'sort_order' => 'nullable|integer',
        ]);

        $image = null;

        if ($request->hasFile('image')) {

            // Small slider thumbnail next to the brand text
            $image = $this->compressAndStore(
                $request->file('image'),
                'brand-section-slider',
                600,
                80
            );
        }

        $home_brand_section_id = HomeBrandSection::where('status', 1)->first()->id ?? null;
        HomeBrandSectionImage::create([
            'home_brand_section_id' => $home_brand_section_id,
            'image' => $image,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.home-brand-section-images.index')
            ->with('success', 'Slider image added successfully.');
    }

    public function edit($id)
    {
        $item = HomeBrandSectionImage::findOrFail($id);

        $sections = HomeBrandSection::where('status', 1)->get();

        return view(
            'admin.home.brand-section-images.edit',
            compact('item', 'sections')
        );
    }

    public function update(Request $request, $id)
    {
        $item = HomeBrandSectionImage::findOrFail($id);

        $request->validate([
            'sort_order' => 'nullable|integer',
        ]);

        $image = $item->image;

        if ($request->hasFile('image')) {

            if (
                $item->image &&
                Storage::disk('public')->exists($item->image)
            ) {
                Storage::disk('public')->delete($item->image);
            }

            // Small slider thumbnail next to the brand text
            $image = $this->compressAndStore(
                $request->file('image'),
                'brand-section-slider',
                600,
                80
            );
        }
        $home_brand_section_id = HomeBrandSection::where('status', 1)->first()->id ?? null;
        $item->update([
            'home_brand_section_id' => $home_brand_section_id,
            'image' => $image,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status ?? 1,
        ]);

        return redirect()
            ->route('admin.home-brand-section-images.index')
            ->with('success', 'Slider image updated successfully.');
    }

    public function destroy($id)
    {
        $item = HomeBrandSectionImage::findOrFail($id);

        if (
            $item->image &&
            Storage::disk('public')->exists($item->image)
        ) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return response()->json([
            'status' => true,
            'message' => 'Slider image deleted successfully.'
        ]);
    }
}