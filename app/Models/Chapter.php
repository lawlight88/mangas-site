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
        'order',
    ];

    public function manga()
    {
        return $this->belongsTo(Manga::class, 'id_manga');
    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'id_chapter');
    }
}
