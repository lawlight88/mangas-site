<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'id_user',
        'id_chapter',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'id_chapter');
    }
}
