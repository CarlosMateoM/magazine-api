<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use App\Services\AzureBlobService;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class FileController extends Controller
{
    private $azureBlobService;

    public function __construct(AzureBlobService $azureBlobService)
    {
        $this->azureBlobService = $azureBlobService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = QueryBuilder::for(File::class)
            ->allowedFilters(['name', 'type'])
            ->allowedSorts(['name', 'created_at'])
            ->paginate(6);

        return response()->json(
            $files
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = $request->file('file');

        $fileType = explode('/', $file->getMimeType());

        $blobName = uniqid() . '.' . $file->getClientOriginalExtension();

        $response = $this->azureBlobService->uploadBlob($blobName, $file);

        $fileStored = new File();

        $fileStored->name = $request->name;
        $fileStored->hash = $response['hash'];
        $fileStored->url = $response['url'];
        $fileStored->type = $fileType[0];  
        $fileStored->description = $request->description;

        $fileStored->save();
        
        return response()->json($fileStored, 201);
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
