<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Services\ExpenseService;
use Illuminate\Http\Request;

class ExpenseReportController extends Controller
{
    public function __construct(
        private ExpenseService $expenseService,
    )
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $total = $this->expenseService->getTotalExpensestMonth($user->id);

        return response()->json([
            'total_expense' => $total,
            'message' => 'Total expense for the month retrieved successfully.'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        //
    }
}
