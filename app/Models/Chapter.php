<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_manga',
        'name',
        'path',
        'pages'
    ];

    protected $casts = [
        'pages' => 'integer'
    ];

    public function manga()
    {
        return $this->belongsTo(Manga::class);
    }
}
