<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AttributeValueSlugSeeder extends Seeder
{
    /**
     * Backfill slugs for any attribute_values rows missing one.
     * Slugs are unique per attribute_id (not globally), matching the
     * unique(['attribute_id', 'slug']) constraint on the table.
     */
    public function run(): void
    {
        AttributeValue::query()
            ->where(function ($query) {
                $query->whereNull('slug')->orWhere('slug', '');
            })
            ->orderBy('id')
            ->chunkById(200, function ($values) {

                foreach ($values as $value) {

                    $base = Str::slug($value->value);
                    $slug = $base;
                    $i = 1;

                    while (
                        AttributeValue::where('attribute_id', $value->attribute_id)
                            ->where('slug', $slug)
                            ->where('id', '!=', $value->id)
                            ->exists()
                    ) {
                        $slug = $base . '-' . $i++;
                    }

                    $value->update(['slug' => $slug]);

                    $this->command?->info("AttributeValue #{$value->id} -> {$slug}");
                }

            });

        $this->command?->info('Attribute value slugs backfilled.');
    }
}