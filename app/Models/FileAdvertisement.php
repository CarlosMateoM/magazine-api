<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileAdvertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_id',
        'advertisement_id',
    ];

    public function file(){
        return $this->belongsTo(File::class);
    }

    public function advertisement(){
        return $this->belongsTo(Advertisement::class);
    }

}
