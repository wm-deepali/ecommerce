<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use App\Imports\BrandImport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::with('categories')
            ->latest()
            ->paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        $categories = Category::active()
            ->orWhere('parent_id', 0)
            ->orderBy('id')
            ->get();

        return view(
            'admin.brands.create',
            compact('categories')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'categories' => 'required|array'
        ]);

        $logo = null;

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo')->store('brands', 'public');
        }

        $brand = Brand::create([
            'name' => $request->name,
            'logo' => $logo,
            'status' => $request->status ?? 1
        ]);

        // Save brand categories
        $brand->categories()->sync($request->categories);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand Created');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        $categories = Category::active()->orWhere('parent_id', 0)
            ->orderBy('id')->get();

        $selectedCategories = $brand->categories
            ->pluck('id')
            ->toArray();

        return view(
            'admin.brands.edit',
            compact(
                'brand',
                'categories',
                'selectedCategories'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'categories' => 'required|array'
        ]);

        $brand = Brand::findOrFail($id);

        $logo = $brand->logo;

        if ($request->hasFile('logo')) {

            // delete old image
            if ($brand->logo && Storage::disk('public')->exists($brand->logo)) {
                Storage::disk('public')->delete($brand->logo);
            }

            // store new image
            $logo = $request->file('logo')->store('brands', 'public');
        }

        $brand->update([
            'name' => $request->name,
            'logo' => $logo,
            'status' => $request->status ?? 1
        ]);

        // Update category mapping
        $brand->categories()->sync($request->categories);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand Updated');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        // delete image from storage
        if ($brand->logo && Storage::disk('public')->exists($brand->logo)) {
            Storage::disk('public')->delete($brand->logo);
        }

        $brand->delete();

        return response()->json(['message' => 'Deleted']);
    }

    public function import()
    {
        return view('admin.brands.import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'file' => 'required|mimetypes:text/plain,text/csv,application/vnd.ms-excel'
        ]);

        try {
            Excel::import(
                new BrandImport,
                $request->file('file')
            );


            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Brands imported successfully.');

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
                'app/public/brands'
            );

            if (!file_exists($extractPath)) {
                mkdir($extractPath, 0777, true);
            }

            $zip->extractTo($extractPath);

            $zip->close();

            return back()->with(
                'success',
                'Brand logos uploaded successfully.'
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
            'name',
            'logo_name',
            'categories',
            'status'
        ];

        $sampleRow = [
            'Parker',
            'parker.jpg',
            'Corporate Gifts, Diaries',
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
            'attachment; filename=brands_import_sample.csv'
        );

        return $response;
    }

    public function downloadCategoryReference()
    {
        $categories = Category::orWhere('parent_id', 0)
            ->orderBy('id')->get([
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
            'attachment; filename=brand_category_reference.csv'
        );

        return $response;
    }

}