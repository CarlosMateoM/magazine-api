<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseCategoryRequest;
use App\Http\Requests\UpdateExpenseCategoryRequest;
use App\Http\Resources\ExpenseCategoryResource;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $expenseCategories = ExpenseCategory::query()
            ->paginate($request->input('per_page', 10));

        return ExpenseCategoryResource::collection($expenseCategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseCategoryRequest $request)
    {
        $expenseCategory = ExpenseCategory::create($request->validated());

        return new ExpenseCategoryResource($expenseCategory);
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseCategory $expenseCategory)
    {
        return new ExpenseCategoryResource($expenseCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseCategoryRequest $request, ExpenseCategory $expenseCategory)
    {
        $expenseCategory->update($request->validated());

        return new ExpenseCategoryResource($expenseCategory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();

        return response()->json(null, 204);
    }
}
