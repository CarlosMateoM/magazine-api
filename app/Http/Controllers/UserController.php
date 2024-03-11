<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Author;
use App\Models\User;
use GuzzleHttp\Psr7\Query;
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


    public function index()
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

        return response()->json(UserResource::collection($query->get()));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = new User();

        $user->name = $request->firstName . ' ' .  $request->lastName;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = 2;
        
        $user->save();

        return response()->json(new UserResource($user), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
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
