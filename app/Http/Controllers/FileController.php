<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Services\File\FileService;
use Illuminate\Http\Request;


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

        return FileResource::collection($files)->resource;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFileRequest $request)
    {
        $file = $this->fileService->createFile($request);

        return new FileResource($file);
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        $file = $this->fileService->getFile($file);

        return new FileResource($file);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFileRequest $request, File $File)
    {
        $file = $this->fileService->updateFile($request, $File);

        return new FileResource($file);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        $this->fileService->deleteFile($file);

        return response()->noContent();
    }
}
