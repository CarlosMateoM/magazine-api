<?php

namespace App\Services\File;

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

    public function saveFile($file)
    {
        $blobName = uniqid();

        if ($this->imageProcessingService->isImage($file)) {
            $file = $this->imageProcessingService->processImage($file);
            $blobName .= '.webp';
        } else {
            $blobName .= '.' . $file->getClientOriginalExtension();
        }

        return $this->azureBlobService->uploadBlob($blobName, $file);
    }
}
