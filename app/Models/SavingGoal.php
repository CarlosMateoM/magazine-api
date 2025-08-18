<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'target_amount',
        'current_amount',
        'target_date'
    ];
}
