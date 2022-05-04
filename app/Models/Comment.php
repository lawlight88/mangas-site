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

    public static function withRedirectParams()
    {
        return Comment::with(['chapter' => function($q) {
            $q->select('id', 'id_manga', 'order');
        }]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'id_chapter');
    }
}
