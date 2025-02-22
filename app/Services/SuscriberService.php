<?php

namespace App\Services;

use App\Models\Suscriber;

class SuscriberService 
{

    public function create(array $data): Suscriber
    {
        return Suscriber::create($data);
    }
}