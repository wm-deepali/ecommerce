<?php

namespace App\Imports;

use App\Models\GiftingOccasion;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GiftingOccasionImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            if (empty($row['title'])) {
                continue;
            }

            $exists = GiftingOccasion::where(
                'title',
                trim($row['title'])
            )->first();

            if ($exists) {
                continue;
            }

            $image = null;

            if (!empty($row['image_name'])) {

                $imagePath = 'gifting/' . trim($row['image_name']);

                if (storage_path('app/public/' . $imagePath)) {
                    $image = $imagePath;
                }
            }

            GiftingOccasion::create([
                'title' => trim($row['title']),

                'sub_title' => $row['sub_title'] ?? null,

                'short_description' => $row['short_description'] ?? null,

                'slug' => Str::slug($row['title']),

                'meta_title' => $row['meta_title'] ?? null,

                'meta_description' => $row['meta_description'] ?? null,

                'icon' => $row['icon'] ?? null,

                'image' => $image,

                'status' => $row['status'] ?? 1,
            ]);
        }
    }
}