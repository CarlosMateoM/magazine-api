<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Spatie\QueryBuilder\QueryBuilder;

class AuthorController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Author::class, 'author');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = QueryBuilder::for(Author::class)
            ->filterByName()
            ->allowedIncludes(['file', 'articles']);

        
        return response()->json(AuthorResource::collection($query->get()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {    
        $author = new Author();

        $author->first_name = $request->firstName;
        $author->last_name = $request->lastName;
        $author->biography = '';
        $author->file_id = $request->image['id'];

        $author->save();

        return response()->json(new AuthorResource($author), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $author->first_name = $request->firstName;
        $author->last_name = $request->lastName;
        $author->biography = '';
        $author->file_id = $request->image['id'];

        $author->save();

        return response()->json(new AuthorResource($author));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        //
    }
}
