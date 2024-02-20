<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleSection extends Model
{
    use HasFactory;

    protected $table = 'article_section';

    protected $fillable = ['article_id', 'section_id'];


    public function articles()
    {
        return $this->belongsTo(Article::class);
    }

    public function sections()
    {
        return $this->belongsTo(Section::class);
    }
}
