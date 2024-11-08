<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
     {
        $this->authorizeResource(User::class, 'user');
     }


    public function index(Request $request)
    {
        $query = QueryBuilder::for(User::class)
            ->allowedFilters([
                'name',
                'email',
                'role.name',
            ])
            ->allowedIncludes([
                'role',
                'role.permissions',
                'articles',
            ]);

            if(!$request->user()->hasRole('admin')) {
                
                $query->where('is_public_author', true);

                $query->where('id', '!=', $request->user()->id);
            }
            

        $users = UserResource::collection($query->paginate(10)->appends($request->query()));

        return response()->json($users->resource);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = new User();

        $user->name                 = $request->input('name');
        $user->email                = $request->input('email');
        $user->biography            = $request->input('biography');
        $user->password             = bcrypt($request->input('password'));
        $user->is_public_author     = $request->input('is_public_author', false);
        $user->is_locked_account    = $request->input('is_locked_account', false);
        
        $user->file_id              = $request->input('file.id');
        $user->role_id              = $request->input('role.id');
        
        $user->save();

        return response()->json(new UserResource($user), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('role', 'role.permissions', 'articles');

        return response()->json(new UserResource($user));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
