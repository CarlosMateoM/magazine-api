<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSavingGoalRequest;
use App\Http\Requests\UpdateSavingGoalRequest;
use App\Http\Resources\SavingGoalResource;
use App\Models\SavingGoal;
use Illuminate\Http\Request;

class SavingGoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $savingGoals = SavingGoal::where('user_id', $user->id)
            ->paginate($request->input('per_page', 10));

        return SavingGoalResource::collection($savingGoals);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSavingGoalRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = $request->user()->id;

        $savingGoal = SavingGoal::create($data);

        return new SavingGoalResource($savingGoal);
    }

    /**
     * Display the specified resource.
     */
    public function show(SavingGoal $savingGoal)
    {
        return new SavingGoalResource($savingGoal);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSavingGoalRequest $request, SavingGoal $savingGoal)
    {
        $data = $request->validated();

        $savingGoal->update($data);

        return new SavingGoalResource($savingGoal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SavingGoal $savingGoal)
    {
        $savingGoal->delete();

        return response()->json(null, 204);
    }
}
