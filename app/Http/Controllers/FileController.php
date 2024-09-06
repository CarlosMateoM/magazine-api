<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Services\FileService;
use App\Services\FileStorageService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;


class FileController extends Controller
{

    public function __construct(
        private FileService $fileService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $files = $this->fileService->getFiles($request);

        return response()->json(FileResource::collection($files)->resource);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFileRequest $request)
    {
        try {

            
            return response()->json($fileStored, 201);
            
        } catch (Exception $e) {

            Log::error('File upload failed: ' . $e->getMessage());

            return response()->json(['error' => 'File upload failed'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(File $File)
    {
        return response()->json(new FileResource($File));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFileRequest $request, File $File)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $File)
    {
        //
    }
}
