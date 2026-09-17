<?php

namespace App\Support;

use Filament\Forms\Components\FileUpload;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImageUploadDefaults
{
    private const MAX_BYTES = 2 * 1024 * 1024;

    /**
     * Auto-compress: resize oversized photos client-side for a faster upload,
     * then guarantee the 2MB cap server-side (client-side resize alone can't
     * be trusted — Filament's own size validation runs on the original file
     * before that resize happens, so relying on it would reject big photos
     * instead of shrinking them).
     */
    public static function apply(FileUpload $upload): FileUpload
    {
        return $upload
            ->imageResizeMode('contain')
            ->imageResizeTargetWidth('1920')
            ->imageResizeTargetHeight('1920')
            ->imageResizeUpscale(false)
            ->afterStateUpdated(function ($state): void {
                foreach (is_array($state) ? $state : [$state] as $file) {
                    if ($file instanceof TemporaryUploadedFile) {
                        ImageCompressor::compress($file, self::MAX_BYTES);
                    }
                }
            });
    }
}
