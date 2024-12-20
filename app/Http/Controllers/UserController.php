<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

        if (!$request->user()->hasRole('admin')) {

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
        $user->password             = $request->input('password');
        $user->role_id              = $request->input('role.id');
        $user->file_id              = $request->input('file.id', null);
        $user->is_locked_account    = $request->input('is_locked_account', false);

        $user->save();

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('role', 'role.permissions');

        return response()->json(new UserResource($user));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {

        if (!Hash::check($request->input('old_password'), $user->password)) {
            return response()->json([
                'message' => 'Ha ocurrido un error, revise los datos e intente nuevamente',
                'errors' => [
                    'old_password' => ['contraseña incorrecta'],
                ],
            ], 422);
        }

        $user->name                 = $request->input('name', $user->name);
        $user->email                = $request->input('email', $user->email);
        $user->file_id              = $request->input('file_id', $user->file_id);

        if ($request->filled('password')) {
            $user->password         = $request->input('password');
        }

        $user->save();

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
