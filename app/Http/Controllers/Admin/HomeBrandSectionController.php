<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBrandSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\CompressesImages;

class HomeBrandSectionController extends Controller
{
    use CompressesImages;

    public function edit()
    {
        $item = HomeBrandSection::first();

        return view(
            'admin.home.brand-section.edit',
            compact('item')
        );
    }

    public function update(Request $request)
    {
        $item = HomeBrandSection::first();

        if (!$item) {
            $item = new HomeBrandSection();
        }

        $image = $item->main_image;

        if ($request->hasFile('main_image')) {

            if ($image) {
                Storage::disk('public')->delete($image);
            }

            // Large hero-style image next to the slider — keep a generous width
            $image = $this->compressAndStore(
                $request->file('main_image'),
                'brand-section',
                1400,
                80
            );
        }

        $item->updateOrCreate(
            ['id' => $item->id ?? null],
            [
                'subtitle' => $request->subtitle,
                'title' => $request->title,
                'description' => $request->description,
                'button_text' => $request->button_text,
                'button_link' => $request->button_link,
                'main_image' => $image,
                'status' => $request->status ?? 1,
            ]
        );

        return back()->with(
            'success',
            'Section updated successfully.'
        );
    }
}