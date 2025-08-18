<?php

namespace App\Services;

use App\Models\Income;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class IncomeService
{

    public function __construct(
        private BalanceService $balanceService
    ) {}

    public function getIncomesTotalMonth(int $userId): float
    {
        $startMonth = now()->startOfMonth();
        $endMonth = now()->endOfMonth();

        return Income::where('user_id', $userId)
            ->whereBetween('created_at', [$startMonth, $endMonth])
            ->sum('amount');
    }   

    public function getIncomes(array $data, User $user): LengthAwarePaginator
    {
        $startMonth = now()->startOfMonth();
        $endMonth = now()->endOfMonth();

        return Income::where('user_id', $user->id)
            ->whereBetween('created_at', [$startMonth, $endMonth])
            ->orderBy('created_at', 'desc')
            ->paginate($data['per_page'] ?? 10);
    }
   


    public function createIncome(array $data, User $user): Income
    {
        return DB::transaction(function () use ($data, $user) {

            $income = Income::create($data);

            $this->balanceService->addIncomeToBalance($user->id, $income->amount);

            return $income;
        });
    }

}
