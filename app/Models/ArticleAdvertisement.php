<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleAdvertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'advertisement_id',
    ];

    public function article(){
        return $this->belongsTo(Article::class);
    }

    public function advertisement(){
        return $this->belongsTo(Advertisement::class);
    }
}
