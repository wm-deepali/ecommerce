<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;

trait CompressesImages
{
    /**
     * Compress & store an uploaded image as WebP.
     * Resizes down to max width (keeps aspect ratio, never upscales)
     * and re-encodes as WebP at the given quality to shrink file size.
     */
    protected function compressAndStore(
        UploadedFile $file,
        string $folder,
        int $maxWidth = 1200,
        int $quality = 80
    ): string {
        $manager = ImageManager::usingDriver(Driver::class);

        $image = $manager->decode($file);

        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        $encoded = $image->encodeUsingFormat(Format::WEBP, quality: $quality);

        $filename = Str::uuid() . '.webp';
        $path = trim($folder, '/') . '/' . $filename;

        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }

    protected function recompressExistingFile(
        string $path,
        int $maxWidth = 1200,
        int $quality = 80
    ): ?string {
        if (str_ends_with(strtolower($path), '.webp')) {
            return null; // already compressed by the new upload flow
        }

        if (!Storage::disk('public')->exists($path)) {
            return null;
        }

        $manager = ImageManager::usingDriver(Driver::class);

        $absolute = Storage::disk('public')->path($path);
        $image = $manager->decode($absolute);

        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        $encoded = $image->encodeUsingFormat(Format::WEBP, quality: $quality);

        $folder = trim(pathinfo($path, PATHINFO_DIRNAME), '.');
        $filename = Str::uuid() . '.webp';
        $newPath = trim($folder, '/') . '/' . $filename;

        Storage::disk('public')->put($newPath, (string) $encoded);
        Storage::disk('public')->delete($path);

        return $newPath;
    }

    /**
     * Generate a smaller thumb from an existing file already on the public
     * disk, saved as a new file (does NOT delete the source — the source
     * is the main image, which stays as-is). Used for backfilling rows
     * whose `thumb` column was never populated.
     */
    protected function generateThumbFromPath(
        string $path,
        int $maxWidth = 400,
        int $quality = 80
    ): ?string {
        if (!Storage::disk('public')->exists($path)) {
            return null;
        }

        $manager = ImageManager::usingDriver(Driver::class);

        $absolute = Storage::disk('public')->path($path);
        $image = $manager->decode($absolute);

        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        $encoded = $image->encodeUsingFormat(Format::WEBP, quality: $quality);

        $folder = trim(pathinfo($path, PATHINFO_DIRNAME), '.');
        $filename = Str::uuid() . '.webp';
        $thumbPath = trim($folder, '/') . '/' . $filename;

        Storage::disk('public')->put($thumbPath, (string) $encoded);

        return $thumbPath;
    }
}