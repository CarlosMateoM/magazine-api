<?php

namespace App\Services\File;

use Illuminate\Http\UploadedFile;

class FileStorageService
{
    private $azureBlobService;
    private $imageProcessingService;

    public function __construct(
        AzureBlobService $azureBlobService,
        ImageProcessingService $imageProcessingService
    ) {
        $this->azureBlobService = $azureBlobService;
        $this->imageProcessingService = $imageProcessingService;
    }

    public function saveFile(UploadedFile $file, string $blobName): string
    {
        if ($this->imageProcessingService->isImage($file)) {
            $blobName .= '.webp';
            $file = $this->imageProcessingService->processImage($file);
        } else {
            $blobName .= '.' . $file->getClientOriginalExtension();
        }

        return $this->azureBlobService->uploadBlob($blobName, $file);
    }
}
