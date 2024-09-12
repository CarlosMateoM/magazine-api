<?php

namespace App\Exceptions;

use Exception;

class FileServiceException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function failedToProcessImage(Exception $previous, $message = "Failed to process image"): self
    {
        return new self($message, 500, $previous);
    }

    public static function failedToUploadFile($message = "Failed to upload file"): self
    {
        return new self($message, 500);
    }

    public static function invalidFileType($message = "Invalid file type"): self
    {
        return new self($message, 400);
    }

    public static function storageProviderError(
        Exception $previous, $message = "Error connecting to storage provider"): self
    {
        return new self($message, 503, $previous);
    }
}
