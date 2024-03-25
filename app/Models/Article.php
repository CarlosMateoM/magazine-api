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
        'user_id',
        'summary',
        'published_at',
        'author_id',
        'category_id',
        'file_id',
        'municipality_id',
    ];

    protected $dates = ['published_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }   

    public function author(){
        return $this->belongsTo(Author::class);
    }

    public function sections(){
        return $this->belongsToMany(Section::class);
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

    public function galleries(){
        return $this->hasMany(Gallery::class);
    }

    public function isPublished(){
        return $this->status === 'PUBLISHED';
    }

    public function updatePublishedAt(){
        if($this->published_at == null && $this->status == 'PUBLISHED'){ 
            $this->published_at = now();
        } 
    }
    
}
