<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'caption',
        'file_id',
        'article_id',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
