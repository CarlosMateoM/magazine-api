<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use App\Services\ExpenseService;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{

    public function __construct(
        private ExpenseService $expenseService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $expenses = Expense::where('user_id', $user->id)
            ->with('fixedExpense', 'expenseCategory')
            ->orderBy('created_at', 'desc')
            ->paginate($request->input('per_page', 10));

        return ExpenseResource::collection($expenses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {
        $data = $request->validated();

        $user = $request->user();

        $data['user_id'] = $user->id;

        $expense = $this->expenseService->createExpense($data, $user->id);

        return new ExpenseResource($expense);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        return new ExpenseResource($expense);
    }
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $data = $request->validated();

        $expense->update($data);

        return new ExpenseResource($expense);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return response()->noContent();
    }
}
