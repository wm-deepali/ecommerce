<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;

class HomeSliderController extends Controller
{
    public function index()
    {
        $sliders = HomeSlider::orderBy('sort_order')
            ->latest()
            ->paginate(10);

        return view('admin.home.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.home.sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([

            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'link' => [
                'nullable',
                'url'
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0'
            ],

            'status' => [
                'required',
                'in:0,1'
            ]

        ]);

        $image = null;

        if ($request->hasFile('image')) {

            $image = $this->compressAndStore(
                $request->file('image'),
                'home-sliders'
            );
        }

        HomeSlider::create([

            'image' => $image,
            'link' => $request->link,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status

        ]);

        return redirect()
            ->route('admin.home.sliders.index')
            ->with('success', 'Slider created successfully.');
    }

    public function edit($id)
    {
        $slider = HomeSlider::findOrFail($id);

        return view(
            'admin.home.sliders.edit',
            compact('slider')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'link' => [
                'nullable',
                'url'
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0'
            ],

            'status' => [
                'required',
                'in:0,1'
            ]

        ]);

        $slider = HomeSlider::findOrFail($id);

        $image = $slider->image;

        if ($request->hasFile('image')) {

            if (
                $slider->image &&
                Storage::disk('public')->exists($slider->image)
            ) {
                Storage::disk('public')->delete($slider->image);
            }

            $image = $this->compressAndStore(
                $request->file('image'),
                'home-sliders'
            );
        }

        $slider->update([

            'image' => $image,
            'link' => $request->link,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status

        ]);

        return redirect()
            ->route('admin.home.sliders.index')
            ->with('success', 'Slider updated successfully.');
    }

    public function destroy($id)
    {
        $slider = HomeSlider::findOrFail($id);

        if (
            $slider->image &&
            Storage::disk('public')->exists($slider->image)
        ) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return response()->json([
            'message' => 'Slider deleted successfully.'
        ]);
    }

    /**
     * ✅ Compress & store an uploaded image as WebP.
     * Sliders render as a full-width hero banner, so keep width generous —
     * unlike category cards these are the largest images on the site.
     */
    private function compressAndStore(
        UploadedFile $file,
        string $folder,
        int $maxWidth = 1920,
        int $quality = 80
    ): string {
        $manager = ImageManager::usingDriver(Driver::class);

        $image = $manager->decode($file);

        // Only downscale, never upscale
        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        $encoded = $image->encodeUsingFormat(Format::WEBP, quality: $quality);

        $filename = Str::uuid() . '.webp';
        $path = trim($folder, '/') . '/' . $filename;

        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }
}