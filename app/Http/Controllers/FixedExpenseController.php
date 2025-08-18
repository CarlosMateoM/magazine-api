<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFixedExpenseRequest;
use App\Http\Requests\UpdateFixedExpenseRequest;
use App\Http\Resources\FixedExpenseResource;
use App\Models\FixedExpense;
use Illuminate\Http\Request;

class FixedExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $fixedExpenses = FixedExpense::where('user_id', $user->id)
            ->with('expenseCategory')
            ->paginate($request->input('per_page', 10));

        return FixedExpenseResource::collection($fixedExpenses);
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFixedExpenseRequest $request)
    {
        $fixedExpense = FixedExpense::create($request->validated());

        return response()->json($fixedExpense, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(FixedExpense $fixedExpense)
    {
        return new FixedExpenseResource($fixedExpense);
    }
 

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFixedExpenseRequest $request, FixedExpense $fixedExpense)
    {
        $fixedExpense->update($request->validated());

        return new FixedExpenseResource($fixedExpense);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FixedExpense $fixedExpense)
    {
        $fixedExpense->delete();

        return response()->json(null, 204);
    }
}
