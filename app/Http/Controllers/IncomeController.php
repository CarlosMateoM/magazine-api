<?php

namespace App\Http\Controllers;

use App\Http\Resources\IncomeResource;
use App\Models\Income;
use App\Services\IncomeService;
use Illuminate\Http\Request; 

class IncomeController extends Controller
{

    public function __construct(private IncomeService $incomeService)
    {
        
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $incomes = $this->incomeService->getIncomes($request->all(), $user);

        return IncomeResource::collection($incomes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'source' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        $user = $request->user();

        $data = $request->all();

        $data['user_id'] = $user->id;

        $income = $this->incomeService->createIncome($data, $user);

        return new IncomeResource($income);
    }

    /**
     * Display the specified resource.
     */
    public function show(Income $income)
    {
        return new IncomeResource($income);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income)
    {
        $request->validate([
            'source' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        $income->update($request->all());

        return new IncomeResource($income);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        $income->delete();

        return response()->json(null, 204);
    }
}
