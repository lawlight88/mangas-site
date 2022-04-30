<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_chapter',
        'path',
        'order',
    ];

    public $timestamps = false;

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'id_chapter');
    }

    // public function manga()
    // {
    //     return $this->belongsTo(Manga::class, 'id_manga');
    // }
}
