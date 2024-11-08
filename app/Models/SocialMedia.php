<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;

    protected $filable = [
        'name',
        'username',
        'url',
        'user_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
