<?php

namespace App\Services\File;

use App\Exceptions\FileServiceException;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;

class ImageProcessingService
{
    private const DEFAULT_QUALITY = 85;
    private const MIME_TYPE = 'image/webp';

    public function __construct(
        private ImageManager $manager
    ) {}

    public function isImage(UploadedFile $file): bool
    {
        return strpos($file->getMimeType(), 'image/') === 0;
    }

    public function processImage(UploadedFile $file, int $quality = self::DEFAULT_QUALITY): ProcessedFile
    {
        try {
            $image = $this->manager->read($file);

            $processedImage = $image->toWebp($quality);

            return new ProcessedFile($processedImage, self::MIME_TYPE);

        } catch (\Exception $e) {

            throw FileServiceException::failedToProcessImage($e);
        }
    }
}
