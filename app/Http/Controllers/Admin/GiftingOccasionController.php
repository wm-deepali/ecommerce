<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\GiftingOccasion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Imports\GiftingOccasionImport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;

class GiftingOccasionController extends Controller
{
    public function index()
    {
        $occasions = GiftingOccasion::latest()->paginate(10);
        return view('admin.gifting_occasions.index', compact('occasions'));
    }

    public function create()
    {
        return view('admin.gifting_occasions.create');
    }

    /**
     * ✅ Compress & store an uploaded image as WebP.
     * Resizes down to max width (keeps aspect ratio, never upscales)
     * and re-encodes as WebP at given quality to shrink file size.
     */
    private function compressAndStore(
        UploadedFile $file,
        string $folder,
        int $maxWidth = 800,
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

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $image = null;

        if ($request->hasFile('image')) {
            // Used at ~248x520 and ~515x349 on frontend -> 800px covers both with retina buffer
            $image = $this->compressAndStore(
                $request->file('image'),
                'gifting'
            );
        }

        GiftingOccasion::create([
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'short_description' => $request->short_description,
            'slug' => Str::slug($request->title),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'image' => $image,
            'icon' => $request->icon,
            'status' => $request->status ?? 1,
        ]);

        return back()->with('success', 'Occasion Added Successfully');
    }

    public function edit($id)
    {
        $occasion = GiftingOccasion::findOrFail($id);
        return view('admin.gifting_occasions.edit', compact('occasion'));
    }

    public function update(Request $request, $id)
    {
        $occasion = GiftingOccasion::findOrFail($id);

        $request->validate([
            'title' => 'required'
        ]);

        $image = $occasion->image;

        if ($request->hasFile('image')) {

            // delete old image
            if ($occasion->image && Storage::disk('public')->exists($occasion->image)) {
                Storage::disk('public')->delete($occasion->image);
            }

            // store new (compressed)
            $image = $this->compressAndStore(
                $request->file('image'),
                'gifting'
            );
        }

        $occasion->update([
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'short_description' => $request->short_description,
            'slug' => Str::slug($request->title),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'status' => $request->status ?? 1,
            'icon' => $request->icon,
            'image' => $image,
        ]);

        return redirect()->route('admin.gifting-occasions.index')
            ->with('success', 'Updated Successfully');
    }

    public function destroy($id)
    {
        $occasion = GiftingOccasion::findOrFail($id);

        // delete image from storage
        if ($occasion->image && Storage::disk('public')->exists($occasion->image)) {
            Storage::disk('public')->delete($occasion->image);
        }

        $occasion->delete();

        return response()->json([
            'message' => 'Deleted Successfully'
        ]);
    }

    public function import()
    {
        return view('admin.gifting_occasions.import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'file' => 'required|mimetypes:text/plain,text/csv,application/vnd.ms-excel'
        ]);

        try {

            Excel::import(
                new GiftingOccasionImport,
                $request->file('file')
            );

            return redirect()
                ->route('admin.gifting-occasions.index')
                ->with('success', 'Occasions imported successfully.');

        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

    public function uploadImagesZip(Request $request)
    {
        $request->validate([
            'zip_file' => 'required|mimes:zip'
        ]);

        $zip = new ZipArchive();

        if ($zip->open($request->file('zip_file')->getRealPath()) === true) {

            $extractPath = storage_path(
                'app/public/gifting'
            );

            if (!file_exists($extractPath)) {
                mkdir($extractPath, 0777, true);
            }

            $zip->extractTo($extractPath);

            $zip->close();

            return back()->with(
                'success',
                'Images uploaded successfully.'
            );
        }

        return back()->with(
            'error',
            'Unable to extract ZIP.'
        );
    }

    public function downloadSample()
    {
        $headers = [
            'title',
            'sub_title',
            'short_description',
            'image_name',
            'icon',
            'meta_title',
            'meta_description',
            'status'
        ];

        $sampleRow = [
            'Diwali Gifts',
            'Corporate Diwali Gifts',
            'Best Diwali gifting ideas',
            'diwali.jpg',
            'fa-gift',
            'Diwali Gifts',
            'Corporate Diwali Gifts',
            '1'
        ];

        $response = new StreamedResponse(function () use ($headers, $sampleRow) {

            $handle = fopen('php://output', 'w');

            fputcsv($handle, $headers);
            fputcsv($handle, $sampleRow);

            fclose($handle);
        });

        $response->headers->set(
            'Content-Type',
            'text/csv'
        );

        $response->headers->set(
            'Content-Disposition',
            'attachment; filename=gifting_occasions_sample.csv'
        );

        return $response;
    }
}