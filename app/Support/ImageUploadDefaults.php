<?php

namespace App\Support;

use Filament\Forms\Components\FileUpload;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImageUploadDefaults
{
    private const TARGET_BYTES = 500 * 1024; // ~500 KB — compress toward this.

    /**
     * Accept any upload size and auto-shrink it — never reject outright.
     * (A hard upload-size cap via ->maxSize() was tried, but it rejects the
     * file client-side before this compression hook ever runs, which
     * defeats the point: the whole idea is that no photo, however big, is
     * ever too big to upload — it just gets compressed down instead.)
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
                        ImageCompressor::compress($file, self::TARGET_BYTES);
                    }
                }
            });
    }
}
