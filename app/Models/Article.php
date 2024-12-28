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
        'file_id',
        'author_id',
        'category_id',
        'municipality_id',
    ];

    public function author(){
        return $this->belongsTo(Author::class);
    }   

    public function sections(){
        return $this->belongsToMany(Section::class);
    }
    
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function coverImage(){
        return $this->belongsTo(File::class, 'file_id');
    }

    public function municipality(){
        return $this->belongsTo(Municipality::class);
    }

    public function galleries(){
        return $this->hasMany(Gallery::class);
    }

    public function advertisements(){
        return $this->hasMany(ArticleAdvertisement::class);
    }

    public function keywords(){
        return $this->belongsToMany(Keyword::class);
    }

    public function isPublished(){
        return $this->status === 'published';
    }
    
}
