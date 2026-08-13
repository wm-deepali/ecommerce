<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BrandImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            if (empty($row['name'])) {
                continue;
            }

            $exists = Brand::where(
                'name',
                trim($row['name'])
            )->first();

            if ($exists) {
                continue;
            }

            $logo = null;

            if (!empty($row['logo_name'])) {

                $logoPath = 'brands/' . trim($row['logo_name']);
                if (storage_path('app/public/' . $logoPath)) {
                    $logo = $logoPath;
                }
            }

            $brand = Brand::create([
                'name' => trim($row['name']),
                'logo' => $logo,
                'status' => $row['status'] ?? 1,
            ]);

            if (!empty($row['categories'])) {

                $categoryIds = [];

                $categories = explode(
                    ',',
                    $row['categories']
                );

                foreach ($categories as $catName) {

                    $category = Category::where(
                        'name',
                        trim($catName)
                    )->first();

                    if ($category) {
                        $categoryIds[] = $category->id;
                    }
                }

                $brand->categories()->sync(
                    $categoryIds
                );
            }
        }
    }
}