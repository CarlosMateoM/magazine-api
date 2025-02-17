<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsLetterSubscription extends Model
{
    use HasFactory;

    protected $table = 'newsletter_subscriptions';
    protected $fillable = ['name', 'email', 'isNotificationEnabled'];
    protected $casts = ['isNotificationEnabled' => 'boolean'];
    protected $attributes = [
        'isNotificationEnabled' => true
    ];
}
