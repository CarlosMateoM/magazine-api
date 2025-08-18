<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Validation\ValidationException;

class BalanceService
{
    
    public function addIncomeToBalance(int $userId, float $amount): void
    {
        $user = User::findOrFail($userId);
        $user->balance += $amount;
        $user->save();
    }

    public function subtractFromBalance(int $userId, float $amount): void
    {
        $user = User::findOrFail($userId);

        if($amount > $user->balance) {
            throw ValidationException::withMessages([
                'balance' => ['Insufficient balance'],
            ]);
        }

        $user->balance -= $amount;
        $user->save();
    }
}