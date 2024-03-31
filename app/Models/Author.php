<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_id', 
        'first_name', 
        'last_name', 
        'biography'
    ];


    public function file(){
        return $this->belongsTo(File::class);
    }

    public function articles(){
        return $this->hasMany(Article::class);
    }


    public function scopeFilterByName($query)
    {
        $name = request('filter')['name'] ?? '';

        if(!$name){
            return;
        }

        return $query->whereRaw("CONCAT(first_name, ' ', last_name) like ?", ['%' . $name . '%']);
   
    }   
}
