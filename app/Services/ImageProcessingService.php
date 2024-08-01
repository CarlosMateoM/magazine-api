<?php

namespace App\Services;

use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class ImageProcessingService
{
    private $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    public function isImage($file)
    {
        return strpos($file->getMimeType(), 'image/') === 0;
    }

    public function processImage($file, $quality = 85)
    {
        $image = $this->manager->read($file->getContent());

        $processedImage = $image->toWebp($quality);

        return new ProcessedFile($processedImage, 'image/webp');
    }
}
