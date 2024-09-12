<?php

namespace App\Services\File;

class ProcessedFile
{
    private $content;
    private $mimeType;
    private $size;

    public function __construct($content, $mimeType)
    {
        $this->content = $content;
        $this->mimeType = $mimeType;
        $this->size = strlen($content);
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function getContent()
    {
        return $this->content;
    }
}
