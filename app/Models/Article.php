<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'status',
        'summary',
        'published_at',
        'author_id',
        'category_id',
        'image_id',
        'municipality_id',
    ];

    public function author(){
        return $this->belongsTo(Author::class);
    }
    
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function image(){
        return $this->belongsTo(Image::class);
    }

    public function municipality(){
        return $this->belongsTo(Municipality::class);
    }

    
}
