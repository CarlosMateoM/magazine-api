<?php

namespace App\Services\File;

use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Models\File;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class FileService
{

    public function __construct(
        private FileStorageService $fileStorageService
    ) {}

    public function getFiles(Request $request)
    {
        $files = QueryBuilder::for(File::class)
            ->allowedFilters([
                'name',
                'type'
            ])
            ->orderBy('created_at', 'desc');

        return $files->paginate($request->input('per_page', config('constants.default_per_page')))
            ->appends($request->query());
    }

    public function getFile(File $file): File
    {
        return $file;
    }

    public function createFile(StoreFileRequest $request): File
    {    
        $uuid = uniqid();

        $uploadedFile = $request->file('file');

        $url = $this->fileStorageService->saveFile($uploadedFile, $uuid); 

        $file = new File();

        $file->name         = $request->input('name');
        $file->hash         = $uuid;
        $file->url          = $url;
        $file->type         = explode('/', $uploadedFile->getMimeType())[0];
        $file->description  = $request->input('description');

        $file->save();


        return $file;
    }

    public function updateFile(UpdateFileRequest $request, File $file): File
    {
        /*
        todo: implement file update, but for now we will just update 
        the file name and description because we are not updating the file 
        itself
        
        $fileData = $this->fileStorageService->saveFile($request->file('file'));
        
        $file->hash = $fileData['hash'];
        $file->url = $fileData['url']; 
        $file->type = explode('/', $file->getMimeType())[0];
        */


        $file->name = $request->name;
        $file->description = $request->description;

        $file->save();

        return $file;
    }

    public function deleteFile(File $file): void
    {
        $file->delete();
    }
    
}
