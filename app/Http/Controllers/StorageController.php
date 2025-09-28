<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StorageController extends Controller
{
    //

    public function usage()
    {
        $usage = Cache::get('total_files_size', 0); // in bytes

        return response()->json([
            'unit' => 'GB',
            'usage' => $usage / (1024 * 1024 * 1024)
        ]);
    }
}
