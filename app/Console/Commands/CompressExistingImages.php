<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Models\Category;
use App\Models\GiftingOccasion;
use App\Models\HomeBrandSection;
use App\Models\HomeBrandSectionImage;
use App\Models\HomeDealBanner;
use App\Models\HomeSlider;
use App\Models\ProductImage;
use App\Models\ProductVariantImage;
use App\Models\Testimonial;
use App\Traits\CompressesImages;
use Illuminate\Console\Command;

class CompressExistingImages extends Command
{
    use CompressesImages;

    protected $signature = 'images:compress-existing
                            {--only= : Comma-separated list of targets to run (e.g. products,categories)}
                            {--dry-run : Show what would change without writing anything}';

    protected $description = 'Re-compress images uploaded before compressAndStore existed, in place, as WebP. Also backfills missing thumb columns for products/variants.';

    // Simple targets: one image column, just re-compress in place.
    protected array $simpleTargets = [
        'gifting_occasions' => [
            'model' => GiftingOccasion::class,
            'column' => 'image',
            'max_width' => 800,
            'quality' => 80,
        ],
        'categories' => [
            'model' => Category::class,
            'column' => 'image',
            'max_width' => 400,
            'quality' => 80,
        ],
        'category_size_charts' => [
            'model' => Category::class,
            'column' => 'size_chart_image',
            'max_width' => 1000,
            'quality' => 85,
        ],
        'sliders' => [
            'model' => HomeSlider::class,
            'column' => 'image',
            'max_width' => 1920,
            'quality' => 80,
        ],
        'deal_banners' => [
            'model' => HomeDealBanner::class,
            'column' => 'image',
            'max_width' => 1600,
            'quality' => 80,
        ],
        'brand_section' => [
            'model' => HomeBrandSection::class,
            'column' => 'main_image',
            'max_width' => 1400,
            'quality' => 80,
        ],
        'brand_section_images' => [
            'model' => HomeBrandSectionImage::class,
            'column' => 'image',
            'max_width' => 600,
            'quality' => 80,
        ],
        'blogs' => [
            'model' => Blog::class,
            'column' => 'image',
            'max_width' => 1200,
            'quality' => 80,
        ],
        'testimonials' => [
            'model' => Testimonial::class,
            'column' => 'photo',
            'max_width' => 500,
            'quality' => 80,
        ],
    ];

    // image+thumb targets: re-compress the main image, then backfill or
    // re-compress the thumb from the (now-compressed) main image.
    protected array $thumbTargets = [
        'products' => [
            'model' => ProductImage::class,
            'image_column' => 'image',
            'thumb_column' => 'thumb',
            'image_max_width' => 1200,
            'image_quality' => 80,
            'thumb_max_width' => 400,
            'thumb_quality' => 80,
        ],
        'variant_images' => [
            'model' => ProductVariantImage::class,
            'image_column' => 'image',
            'thumb_column' => 'thumb',
            'image_max_width' => 1200,
            'image_quality' => 80,
            'thumb_max_width' => 400,
            'thumb_quality' => 80,
        ],
    ];

    public function handle(): int
    {
        $only = $this->option('only')
            ? array_map('trim', explode(',', $this->option('only')))
            : null;

        $dryRun = $this->option('dry-run');

        $totalConverted = 0;
        $totalSkipped = 0;

        foreach ($this->simpleTargets as $key => $target) {

            if ($only && !in_array($key, $only)) {
                continue;
            }

            $this->info("Processing [{$key}]...");

            [$converted, $skipped] = $this->processSimpleTarget($target, $dryRun);

            $totalConverted += $converted;
            $totalSkipped += $skipped;
        }

        foreach ($this->thumbTargets as $key => $target) {

            if ($only && !in_array($key, $only)) {
                continue;
            }

            $this->info("Processing [{$key}] (image + thumb)...");

            [$converted, $skipped] = $this->processThumbTarget($target, $dryRun);

            $totalConverted += $converted;
            $totalSkipped += $skipped;
        }

        $this->info("Done. Converted: {$totalConverted}, Skipped: {$totalSkipped}" . ($dryRun ? ' (dry run — no files changed)' : ''));

        return self::SUCCESS;
    }

    protected function processSimpleTarget(array $target, bool $dryRun): array
    {
        $model = $target['model'];
        $column = $target['column'];

        $converted = 0;
        $skipped = 0;

        $rows = $model::whereNotNull($column)
            ->where($column, '!=', '')
            ->get();

        $bar = $this->output->createProgressBar($rows->count());
        $bar->start();

        foreach ($rows as $row) {

            $original = $row->{$column};

            if (str_ends_with(strtolower($original), '.webp')) {
                $skipped++;
                $bar->advance();
                continue;
            }

            if ($dryRun) {
                $this->line("\n  Would convert: {$original}");
                $converted++;
                $bar->advance();
                continue;
            }

            $newPath = $this->recompressExistingFile(
                $original,
                $target['max_width'],
                $target['quality']
            );

            if ($newPath) {
                $row->{$column} = $newPath;
                $row->save();
                $converted++;
            } else {
                $skipped++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        return [$converted, $skipped];
    }

    protected function processThumbTarget(array $target, bool $dryRun): array
    {
        $model = $target['model'];
        $imageColumn = $target['image_column'];
        $thumbColumn = $target['thumb_column'];

        $converted = 0;
        $skipped = 0;

        $rows = $model::whereNotNull($imageColumn)
            ->where($imageColumn, '!=', '')
            ->get();

        $bar = $this->output->createProgressBar($rows->count());
        $bar->start();

        foreach ($rows as $row) {

            $originalImage = $row->{$imageColumn};
            $originalThumb = $row->{$thumbColumn};

            $rowChanged = false;

            // ── Step 1: re-compress the main image if it isn't webp yet ──
            if (!str_ends_with(strtolower($originalImage), '.webp')) {

                if ($dryRun) {
                    $this->line("\n  [{$row->id}] Would compress main image: {$originalImage}");
                    $rowChanged = true;
                } else {
                    $newImagePath = $this->recompressExistingFile(
                        $originalImage,
                        $target['image_max_width'],
                        $target['image_quality']
                    );

                    if ($newImagePath) {
                        $row->{$imageColumn} = $newImagePath;
                        $rowChanged = true;
                    }
                }
            }

            // The path to generate the thumb FROM — the just-compressed
            // image if we changed it this run, otherwise whatever is
            // already stored (which by this point is guaranteed webp
            // unless dry-run, in which case we just report intent).
            $sourceForThumb = $dryRun ? $originalImage : $row->{$imageColumn};

            // ── Step 2: backfill or re-compress the thumb ──
            if (empty($originalThumb)) {

                if ($dryRun) {
                    $this->line("  [{$row->id}] Would generate missing thumb from: {$sourceForThumb}");
                    $rowChanged = true;
                } else {
                    $newThumbPath = $this->generateThumbFromPath(
                        $sourceForThumb,
                        $target['thumb_max_width'],
                        $target['thumb_quality']
                    );

                    if ($newThumbPath) {
                        $row->{$thumbColumn} = $newThumbPath;
                        $rowChanged = true;
                    }
                }

            } elseif (!str_ends_with(strtolower($originalThumb), '.webp')) {

                if ($dryRun) {
                    $this->line("  [{$row->id}] Would re-compress existing thumb: {$originalThumb}");
                    $rowChanged = true;
                } else {
                    $newThumbPath = $this->recompressExistingFile(
                        $originalThumb,
                        $target['thumb_max_width'],
                        $target['thumb_quality']
                    );

                    if ($newThumbPath) {
                        $row->{$thumbColumn} = $newThumbPath;
                        $rowChanged = true;
                    }
                }
            }

            if (!$dryRun && $rowChanged) {
                $row->save();
            }

            $rowChanged ? $converted++ : $skipped++;

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        return [$converted, $skipped];
    }
}