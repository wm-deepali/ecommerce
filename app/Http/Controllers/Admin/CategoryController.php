<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Imports\CategoryImport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;

class CategoryController extends Controller
{
    // ✅ List Page
    public function index(Request $request)
    {
        $query = Category::with('parent', 'children');

        // Parent categories dropdown
        $parentCategories = Category::whereNull('parent_id')
            ->orderBy('name')
            ->get();

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Type filter
        if ($request->type == 'category') {

            $query->whereNull('parent_id');

        } elseif ($request->type == 'subcategory') {

            $query->whereNotNull('parent_id');

            if ($request->filled('category_id')) {
                $query->where('parent_id', $request->category_id);
            }
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');

        $allowedColumns = [
            'id',
            'name',
            'sort_order',
            'status',
            'is_popular'
        ];

        if (in_array($sortBy, $allowedColumns)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $categories = $query
            ->paginate(10)
            ->appends($request->all());

        return view('admin.categories.index', compact(
            'categories',
            'parentCategories'
        ));
    }

    // ✅ Create
    public function create()
    {
        $parents = Category::whereNull('parent_id')->get();

        return view('admin.categories.create', compact('parents'));
    }

    /**
     * ✅ Compress & store an uploaded image as WebP.
     * Resizes down to max width (keeps aspect ratio, never upscales)
     * and re-encodes as WebP at given quality to shrink file size.
     * Same pattern used for La Pavone product image optimization.
     */
    private function compressAndStore(
        UploadedFile $file,
        string $folder,
        int $maxWidth = 1200,
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

    // ✅ Store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $image = null;

        if ($request->hasFile('image')) {
            // Displayed as a small card (~121x171 on frontend) -> keep small, ~3x retina buffer
            $image = $this->compressAndStore(
                $request->file('image'),
                'categories',
                400,
                80
            );
        }

        $sizeChartImage = null;

        if ($request->hasFile('size_chart_image')) {
            // Displayed larger/zoomed (~707x943 on frontend) -> keep bigger, higher quality
            $sizeChartImage = $this->compressAndStore(
                $request->file('size_chart_image'),
                'categories/size-charts',
                1000,
                85
            );
        }

        Category::create([
            'name' => $request->name,
            'sub_title' => $request->sub_title,

            // ✅ slug safe
            'slug' => $request->slug
                ? Str::slug($request->slug)
                : Str::slug($request->name),

            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'image' => $image,
            'size_chart_image' => $sizeChartImage,

            // ✅ FIXED
            'parent_id' => $request->parent_id ?: null,

            // FLAGS
            'is_popular' => $request->is_popular ?? 0,
            'is_featured' => $request->is_featured ?? 0,
            'show_in_navbar' => $request->show_in_navbar ?? 0,

            'added_by' => 'admin',

            'status' => $request->status ?? 1,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category Added Successfully');
    }

    // ✅ Edit
    public function edit(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $parents = Category::whereNull('parent_id')
            ->where('id', '!=', $id)
            ->get();

        $redirect = $request->redirect;

        return view('admin.categories.edit', compact(
            'category',
            'parents',
            'redirect'
        ));
    }

    // ✅ Update
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $image = $category->image;

        if ($request->hasFile('image')) {

            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $image = $this->compressAndStore(
                $request->file('image'),
                'categories',
                400,
                80
            );
        }

        $sizeChartImage = $category->size_chart_image;

        if ($request->hasFile('size_chart_image')) {

            if (
                $category->size_chart_image &&
                Storage::disk('public')->exists($category->size_chart_image)
            ) {
                Storage::disk('public')->delete($category->size_chart_image);
            }

            $sizeChartImage = $this->compressAndStore(
                $request->file('size_chart_image'),
                'categories/size-charts',
                1000,
                85
            );
        }

        $category->update([
            'name' => $request->name,
            'sub_title' => $request->sub_title,

            // ✅ slug safe
            'slug' => $request->slug
                ? Str::slug($request->slug)
                : $category->slug,

            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'image' => $image,
            'size_chart_image' => $sizeChartImage,

            // ✅ FIXED
            'parent_id' => $request->parent_id ?: null,

            'is_popular' => $request->is_popular ?? 0,
            'is_featured' => $request->is_featured ?? 0,
            'show_in_navbar' => $request->show_in_navbar ?? 0,

            'status' => $request->status ?? 1,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect($request->redirect ?? route('admin.categories.index'))
            ->with('success', 'Category Updated Successfully');
    }

    // ✅ Delete
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        if ($category->size_chart_image && Storage::disk('public')->exists($category->size_chart_image)) {
            Storage::disk('public')->delete($category->size_chart_image);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category Deleted Successfully'
        ]);
    }

    public function import()
    {
        return view('admin.categories.import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'file' => 'required|mimetypes:text/plain,text/csv,application/vnd.ms-excel'
        ]);

        try {

            Excel::import(
                new CategoryImport,
                $request->file('file')
            );

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Categories imported successfully.');

        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

    public function downloadSample()
    {
        $headers = [
            'name',
            'sub_title',
            'image_name',
            'parent_category',
            'meta_title',
            'meta_description',
            'is_popular',
            'is_featured',
            'status',
            'sort_order'
        ];

        $sampleRow = [
            'Corporate Gifts',
            'Premium Corporate Gifts',
            'corporate-gifts.jpg',
            '',
            'Corporate Gifts',
            'Corporate Gifts Category',
            '1',
            '1',
            '1',
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
            'attachment; filename=category_import_sample.csv'
        );

        return $response;
    }

    public function uploadImagesZip(Request $request)
    {
        $request->validate([
            'zip_file' => 'required|mimes:zip'
        ]);

        try {

            $zip = new ZipArchive();

            if ($zip->open($request->file('zip_file')->getRealPath()) === true) {

                $extractPath = storage_path(
                    'app/public/categories'
                );

                if (!file_exists($extractPath)) {
                    mkdir($extractPath, 0777, true);
                }

                $zip->extractTo($extractPath);

                $zip->close();

                return back()->with(
                    'success',
                    'Category images uploaded successfully.'
                );
            }

            return back()->with(
                'error',
                'Unable to extract ZIP file.'
            );

        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

    public function downloadParentCategoryReference()
    {
        $categories = Category::whereNull('parent_id')
            ->orWhere('parent_id', 0)
            ->orderBy('id')
            ->get([
                'id',
                'name'
            ]);

        $response = new StreamedResponse(function () use ($categories) {

            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'id',
                'category_name'
            ]);

            foreach ($categories as $category) {

                fputcsv($handle, [
                    $category->id,
                    $category->name
                ]);
            }

            fclose($handle);
        });

        $response->headers->set(
            'Content-Type',
            'text/csv'
        );

        $response->headers->set(
            'Content-Disposition',
            'attachment; filename=parent_category_reference.csv'
        );

        return $response;
    }

}