<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}

//TODO: change name to title
/*

   "image": {
        "id": 8,
        "name": "default",
        "hash": "65a70eb7c91f2.png",
        "url": "https://revistaregion.blob.core.windows.net/media/65a70eb7c91f2.png",
        "description": "default",
        "created_at": "2024-01-16T23:18:21.000000Z",
        "updated_at": "2024-01-16T23:18:21.000000Z"
   

*/