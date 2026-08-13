<?php

namespace App\Imports;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoryImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            if (empty($row['name'])) {
                continue;
            }

            $parentId = null;

            if (!empty($row['parent_category'])) {

                $parent = Category::where(
                    'name',
                    trim($row['parent_category'])
                )->first();

                $parentId = $parent?->id;
            }

            $exists = Category::where(
                'name',
                trim($row['name'])
            )->first();

            if ($exists) {
                continue;
            }

            // IMAGE
            $image = null;

            if (!empty($row['image_name'])) {

                $imagePath = 'categories/' . trim($row['image_name']);

                if (storage_path('app/public/' . $imagePath)) {
                    $image = $imagePath;
                }
            }

            Category::create([
                'name' => trim($row['name']),

                'sub_title' => $row['sub_title'] ?? null,

                'slug' => Str::slug($row['name']),

                'meta_title' => $row['meta_title'] ?? null,
                'meta_description' => $row['meta_description'] ?? null,

                'image' => $image,

                'parent_id' => $parentId,

                'is_popular' => !empty($row['is_popular']) ? 1 : 0,
                'is_featured' => !empty($row['is_featured']) ? 1 : 0,

                'is_sub_category' => $parentId ? 1 : 0,

                'added_by' => 'admin',

                'status' => $row['status'] ?? 1,

                'sort_order' => $row['sort_order'] ?? 0,
            ]);
        }
    }
}