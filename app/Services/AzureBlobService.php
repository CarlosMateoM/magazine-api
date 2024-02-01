<?php

namespace App\Services;

class AzureBlobService {

    private $accountName;
    private $accountKey;
    private $containerName;

    public function __construct() {
        $this->accountName = config('filesystems.disks.azure.account_name');
        $this->accountKey = config('filesystems.disks.azure.account_key');
        $this->containerName = config('filesystems.disks.azure.container_name');
    }

    public function uploadBlob($blobName, $file) {
        
        $fileSize = $file->getSize();

        $date = gmdate('D, d M Y H:i:s T', time());

        $fileType = mime_content_type($file->getPathname());

        $url = "https://{$this->accountName}.blob.core.windows.net/{$this->containerName}/{$blobName}";

        $headers = [
            "x-ms-blob-type: BlockBlob",
            "Content-Type: {$fileType}",
            "x-ms-version: 2020-10-02",
            "x-ms-date: {$date}",
            "Content-Length: {$fileSize}",
            "Authorization: SharedKey {$this->accountName}:{$this->generateSharedKey('PUT', $date, $blobName, $fileSize, $fileType)}"
        ];

        $fileContent = file_get_contents($file->getPathname());

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fileContent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        if ($status !== 201) {
            throw new \Exception('Error al subir el archivo al blob storage');
        }

        return array('url' => $url, 'hash' => $blobName, 'status' => $status);
    }

    private function generateSharedKey($verb, $date, $blobName, $fileSize, $fileType) {
        
        $canonicalizedHeaders = "x-ms-blob-type:BlockBlob\nx-ms-date:{$date}\nx-ms-version:2020-10-02";
        $canonicalizedResource = "/{$this->accountName}/{$this->containerName}/{$blobName}";

        $stringToSign = "{$verb}\n\n\n{$fileSize}\n\n{$fileType}\n\n\n\n\n\n\n{$canonicalizedHeaders}\n{$canonicalizedResource}";
        $signature = base64_encode(hash_hmac('sha256', $stringToSign, base64_decode($this->accountKey), true));

        return $signature;
    }
}
