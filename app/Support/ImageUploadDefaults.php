<?php

namespace App\Support;

use Filament\Forms\Components\FileUpload;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImageUploadDefaults
{
    private const MAX_UPLOAD_KB = 5120; // 5 MB — reject before processing.

    private const TARGET_BYTES = 500 * 1024; // ~500 KB — compress toward this.

    /**
     * Reject uploads over 5MB outright (client-side, before processing), then
     * auto-compress whatever's under that cap down toward ~500KB server-side
     * (client-side resize alone can't be trusted to hit a target — Filament's
     * own size validation runs on the original file before that resize
     * happens, so it only guards the upload ceiling, not the output size).
     */
    public static function apply(FileUpload $upload): FileUpload
    {
        return $upload
            ->maxSize(self::MAX_UPLOAD_KB)
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
