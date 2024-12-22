<?php

namespace App\Services;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AuthorService
{


    public function getAuthors(Request $request)
    {
        return QueryBuilder::for(Author::class)
            ->allowedFilters([
                AllowedFilter::partial('name', 'user.name'),
            ])
            ->allowedIncludes('articles', 'image')
            ->with(['user.image'])
            ->paginate($request->input('per_page', config('constants.default_per_page')));
    }


    public function getAuthor(Author $author): Author
    {
        $author->load([
            'user',
            'image'
        ]);

        return $author;
    }

    public function createAuthor(StoreAuthorRequest $request): Author
    {

        DB::beginTransaction();

        try {

            $user = new User();

            $user->name         = $request->input('name');
            $user->email        = $request->input('email');
            $user->password     = $request->input('password');
            $user->file_id      = $request->input('file_id');
            $user->role_id      = Role::where('name', 'writer')->first()->id;

            $user->save();

            $author = new Author();

            $author->user_id    = $user->id;
            $author->biography  = $request->input('biography');
            $author->is_public  = $request->input('is_public', false);

            $author->save();

            DB::commit();

            return $author;

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateAuthor(UpdateAuthorRequest $request, Author $author): Author
    {
        $author->name       = $request->input('name');
        $author->biography  = $request->input('biography');
        $author->user_id    = $request->input('user_id');
        $author->file_id    = $request->input('file_id');
        $author->is_public  = $request->input('is_public', false);

        $author->save();

        return $author;
    }

    public function deleteAuthor(Author $author): void
    {
        $author->delete();
    }
}
