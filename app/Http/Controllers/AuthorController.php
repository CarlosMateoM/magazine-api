<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use App\Services\AuthorService;
use Illuminate\Http\Request;

class AuthorController extends Controller
{

    public function __construct(
        private AuthorService $authorService
    )
    {
        $this->authorizeResource(Author::class, 'author');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $articles = $this->authorService->getAuthors($request);

        return response()->json(AuthorResource::collection($articles)->resource);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {    
        $author = $this->authorService->createAuthor($request);

        return response()->json(new AuthorResource($author), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        $author = $this->authorService->getAuthor($author);

        return response()->json(new AuthorResource($author));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $author = $this->authorService->updateAuthor($request, $author);

        return response()->json(new AuthorResource($author));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $this->authorService->deleteAuthor($author);

        return response()->json(['deleted_id' => $author->id], 204);
    }
}
