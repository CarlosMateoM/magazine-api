<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSavingGoalDepositRequest;
use App\Http\Requests\UpdateSavingGoalDepositRequest;
use App\Http\Resources\SavingGoalDepositResource;
use App\Models\Expense;
use App\Models\SavingGoal;
use App\Models\SavingGoalDeposit;
use App\Services\BalanceService;
use App\Services\ExpenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SavingGoalDepositController extends Controller
{
    public function __construct(
        private BalanceService $balanceService, 
        private ExpenseService $expenseService,
    ) { }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $deposits = SavingGoalDeposit::where('user_id', $user->id)
                ->with('savingGoal')->paginate(10);

        return SavingGoalDepositResource::collection($deposits);
    }

   
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSavingGoalDepositRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = $request->user()->id;

        return DB::transaction(function () use ($data) {

            $savingGoal = SavingGoal::findOrFail($data['saving_goal_id']);

            $deposit = SavingGoalDeposit::create($data);

            $this->balanceService->subtractFromBalance($deposit->user_id, $deposit->amount);

            $expenseData = [
                'user_id' => $deposit->user_id,
                'expense_category_id' => 7, // Assuming '7' is the ID for "Metas de ahorro"
                'name' => "Deposit to saving goal {$savingGoal->title}",
                'amount' => $deposit->amount,
            ];

            Expense::create($expenseData);
 

            $savingGoal = SavingGoal::findOrFail($deposit->saving_goal_id);

            $savingGoal->increment('current_amount', $deposit->amount);

            return new SavingGoalDepositResource($deposit);
        });


    }

    /**
     * Display the specified resource.
     */
    public function show(SavingGoalDeposit $savingGoalDeposit)
    {
        return new SavingGoalDepositResource($savingGoalDeposit);
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSavingGoalDepositRequest $request, SavingGoalDeposit $savingGoalDeposit)
    {
        $data = $request->validated();

        $savingGoalDeposit->update($data);

        return new SavingGoalDepositResource($savingGoalDeposit);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SavingGoalDeposit $savingGoalDeposit)
    {
        $savingGoalDeposit->delete();

        return response()->noContent();
    }
}
