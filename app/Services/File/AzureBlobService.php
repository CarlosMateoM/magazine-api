<?php

namespace App\Services\File;

use App\Exceptions\FileServiceException;
use GuzzleHttp\Client;

class AzureBlobService
{
    private $accountKey;
    private $apiVersion;
    private $accountName;
    private $containerName;

    public function __construct(
        private Client $client
    ) {
        $this->accountName      = config('filesystems.disks.azure.account_name');
        $this->accountKey       = config('filesystems.disks.azure.account_key');
        $this->containerName    = config('filesystems.disks.azure.container_name');
        $this->apiVersion       = config('filesystems.disks.azure.x_ms_version');
    }

    private function generateSharedKey($verb, $date, $blobName, $fileSize, $fileType): string
    {
        $canonicalizedResource  = "/{$this->accountName}/{$this->containerName}/{$blobName}";
        $canonicalizedHeaders   = "x-ms-blob-type:BlockBlob\nx-ms-date:{$date}\nx-ms-version:2020-10-02";
        $stringToSign           = "{$verb}\n\n\n{$fileSize}\n\n{$fileType}\n\n\n\n\n\n\n{$canonicalizedHeaders}\n{$canonicalizedResource}";
        $signature              = base64_encode(hash_hmac('sha256', $stringToSign, base64_decode($this->accountKey), true));

        return $signature;
    }

    public function uploadBlob(string $blobName, $file): string
    {
        try {

            $date = gmdate('D, d M Y H:i:s T', time());

            $fileSize = $file->getSize();

            $fileType = $file->getMimeType();

            $fileContent = $file->getContent();

            $url = "https://{$this->accountName}.blob.core.windows.net/{$this->containerName}/{$blobName}";

            $headers = [
                "x-ms-blob-type"    => "BlockBlob",
                "Content-Type"      => $fileType,
                "x-ms-version"      => $this->apiVersion,
                "x-ms-date"         => $date,
                "Content-Length"    => $fileSize,
                "Authorization"     => "SharedKey {$this->accountName}:{$this->generateSharedKey('PUT',$date,$blobName,$fileSize,$fileType)}"
            ];

            $this->client->put($url, ['headers' => $headers, 'body' => $fileContent]);

            return $url;
        } catch (\Exception $e) {
            throw FileServiceException::storageProviderError($e);
        }
    }
}
