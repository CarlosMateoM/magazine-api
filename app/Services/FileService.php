<?php 

namespace App\Services;

use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Models\File;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class FileService
{

    private const DEFAULT_PER_PAGE = 10;

    public function __construct(
        private FileStorageService $fileStorageService
    ) {}

    public function getFiles(Request $request)
    {
        $files = QueryBuilder::for(File::class)
            ->allowedFilters('name')
            ->allowedIncludes('municipalities');

        return $files->paginate(self::DEFAULT_PER_PAGE)
        ->appends($request->query());
    }

    public function createFile(StoreFileRequest $file): File
    {
        //return $this->fileStorageService->store($file);

        $file = new File();

        $file->name = $file->getClientOriginalName();

    }

    public function updateFile(UpdateFileRequest $request, File $file): File
    {
        //return $this->fileStorageService->store($file);

        $file->name = $file->getClientOriginalName();

        return $file;
    }

    public function deleteFile(File $file): void
    {
        $file->delete();
    }

}