<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImageCompressor
{
    private const SUPPORTED_MIMES = ['image/jpeg', 'image/png', 'image/webp'];

    /**
     * Re-encode the uploaded file in place (same temp path) until it's under
     * $maxBytes, so whatever saves it next (Filament's disk store, or Spatie
     * Media Library's addMediaFromString) reads the already-compressed bytes.
     *
     * Every early return here means the original, uncompressed file gets
     * stored as-is — each one is logged so a silent failure (missing GD,
     * a corrupt upload, an unsupported format) is visible in the logs
     * instead of just showing up as "compression didn't happen".
     */
    public static function compress(TemporaryUploadedFile $file, int $maxBytes = 2 * 1024 * 1024): void
    {
        if ($file->getSize() <= $maxBytes) {
            return;
        }

        if (! extension_loaded('gd')) {
            Log::warning('ImageCompressor: GD extension not available, skipping compression.', [
                'file' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
            ]);

            return;
        }

        $mime = $file->getMimeType();

        if (! in_array($mime, self::SUPPORTED_MIMES, true)) {
            Log::warning('ImageCompressor: unsupported mime type, skipping compression.', [
                'file' => $file->getClientOriginalName(),
                'mime' => $mime,
                'size' => $file->getSize(),
            ]);

            return;
        }

        $path = $file->path();
        $original = @imagecreatefromstring(file_get_contents($path));

        if (! $original) {
            Log::warning('ImageCompressor: imagecreatefromstring failed, skipping compression.', [
                'file' => $file->getClientOriginalName(),
                'mime' => $mime,
                'size' => $file->getSize(),
                'php_memory_limit' => ini_get('memory_limit'),
            ]);

            return;
        }

        $encoded = self::reduceUntilUnderCap($original, $mime, $maxBytes);
        imagedestroy($original);

        if ($encoded === null) {
            return;
        }

        file_put_contents($path, $encoded);
        clearstatcache(true, $path);

        Log::info('ImageCompressor: compressed upload.', [
            'file' => $file->getClientOriginalName(),
            'original_size' => $file->getSize(),
            'final_size' => strlen($encoded),
        ]);
    }

    /**
     * $original is owned by the caller and is never destroyed here. Any
     * smaller working copy created via imagescale() is owned by this method.
     */
    private static function reduceUntilUnderCap(\GdImage $original, string $mime, int $maxBytes): ?string
    {
        $current = $original;
        $ownsCurrent = false;
        $quality = 85;
        $best = null;

        for ($attempt = 0; $attempt < 10; $attempt++) {
            $encoded = self::encode($current, $mime, $quality);
            $best = $encoded;

            if (strlen($encoded) <= $maxBytes) {
                break;
            }

            if ($quality > 40) {
                $quality -= 15;

                continue;
            }

            $width = (int) round(imagesx($current) * 0.85);
            $height = (int) round(imagesy($current) * 0.85);

            if ($width < 200 || $height < 200) {
                break;
            }

            $resized = imagescale($current, $width, $height);

            if ($resized === false) {
                break;
            }

            if ($ownsCurrent) {
                imagedestroy($current);
            }

            $current = $resized;
            $ownsCurrent = true;
            $quality = 85;
        }

        if ($ownsCurrent) {
            imagedestroy($current);
        }

        return $best;
    }

    private static function encode(\GdImage $image, string $mime, int $quality): string
    {
        ob_start();

        match ($mime) {
            'image/png' => imagepng($image, null, min(9, max(0, (int) round((100 - $quality) / 11)))),
            'image/webp' => imagewebp($image, null, $quality),
            default => imagejpeg($image, null, $quality),
        };

        return ob_get_clean();
    }
}
