<?php

namespace App\Services;

use App\Models\Expense;
use Illuminate\Support\Facades\DB;

class ExpenseService
{

    public function __construct(
        private BalanceService $balanceService,
    ) { }

    
    public function getTotalExpensestMonth(int $userId): float
    {
        $startMonth = now()->startOfMonth();
        $endMonth = now()->endOfMonth();

        return Expense::where('user_id', $userId)
            ->whereBetween('created_at', [$startMonth, $endMonth])
            ->sum('amount');
    }


    public function createExpense(array $data, int $userId): Expense
    {
        return DB::transaction(function () use ($data, $userId) {

            $expense =  Expense::create($data);

            $this->balanceService->subtractFromBalance($userId, $expense->amount);

            return $expense;
        });
    }
}