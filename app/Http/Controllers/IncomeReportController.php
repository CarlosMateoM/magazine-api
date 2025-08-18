<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Services\IncomeService;
use Illuminate\Http\Request;

class IncomeReportController extends Controller
{
    public function __construct(
        private IncomeService $incomeService,
    )
    {
        // Constructor logic if needed
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $total = $this->incomeService->getIncomesTotalMonth($user->id);

        return response()->json([
            'total_income' => $total,
            'message' => 'Total income for the month retrieved successfully.'
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
    public function show(Income $income)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        //
    }
}
