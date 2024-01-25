<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'summary',
        'published_at',
        'author_id',
        'category_id',
        'file_id',
        'municipality_id',
    ];

    protected $dates = ['published_at'];

    public function author(){
        return $this->belongsTo(Author::class);
    }
    
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function file(){
        return $this->belongsTo(File::class);
    }

    public function municipality(){
        return $this->belongsTo(Municipality::class);
    }

    public function updatePublishedAt(){
        if($this->published_at == null && $this->status == 'PUBLISHED'){ 
            $this->published_at = now();
        } 
    }
    
}
