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
        'id_leader',
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

    public static function withRequests()
    {
        return Scanlator::with([
                        'requests' => function($q) {
                            $q->select('id', 'id_requester', 'id_manga', 'status', 'created_at', 'updated_at')
                                ->where('visible_scan', true)
                                ->orderBy('updated_at', 'desc');
                        },
                        'requests.manga:id,name'
        ]);
    }

    public function mangas()
    {
        return $this->hasMany(Manga::class, 'scanlator');
    }

    public function requests()
    {
        return $this->hasMany(\App\Models\Request::class, 'id_requester');
    }

    public function members()
    {
        return $this->hasMany(User::class, 'id_scanlator')->select('id', 'name', 'email');
    }

    public function leader()
    {
        return $this->belongsTo(User::class, 'id_leader')->select('id', 'name', 'email');
    }
}
