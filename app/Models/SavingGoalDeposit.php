<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingGoalDeposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'saving_goal_id',
        'amount',
    ];
}
