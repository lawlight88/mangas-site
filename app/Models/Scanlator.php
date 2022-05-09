<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scanlator extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'desc',
        'leader',
    ];

    public static function getIndexScans()
    {
        return Scanlator::select('id', 'name', 'image', 'created_at')
                        ->paginate(20);
    }

    public static function withLeader()
    {
        return Scanlator::with(['leader' => function($q) {
            $q->select('id', 'name');
        }]);
    }

    public function mangas()
    {
        return $this->hasMany(Manga::class, 'scanlator');
    }

    public function members()
    {
        return $this->hasMany(User::class, 'scanlator');
    }

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader');
    }
}
