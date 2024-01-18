<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Services\AzureBlobService;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ImageController extends Controller
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
        $images = QueryBuilder::for(Image::class)
            ->allowedFilters(['name','description','hash'])
            ->allowedSorts(['name', 'description'])
            ->paginate(5);

        return response()->json([
            $images
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = $request->file('image');

        $blobName = uniqid() . '.' . $file->getClientOriginalExtension();

        $response = $this->azureBlobService->uploadBlob($blobName, $file);


        $image = Image::create([
            'name' => $request->name,
            'hash' => $response['hash'],
            'url' => $response['url'],
            'description' => $request->description,
        ]);


        return response()->json($image, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
    }
}
