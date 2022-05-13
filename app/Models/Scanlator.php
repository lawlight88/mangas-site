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

    public static function withPendingRequests()
    {
        return Scanlator::with([
                        'requests' => function($q) {
                            $q->select('id', 'id_requester', 'id_manga', 'status', 'created_at', 'updated_at')
                                ->where('status', null)
                                ->orderBy('updated_at', 'desc');
                        },
                        'requests.manga:id,name'
        ]);
    }

    public static function withMembers()
    {
        return Scanlator::with([
                            'leader',
                            'members' => function($q) {
                                $q->select('id', 'name', 'id_scanlator', 'joined_scan_at', 'scan_role')
                                    ->orderBy('joined_scan_at');
                            }
        ]);
    }

    public static function withMembersMgmt()
    {
        return Scanlator::with([
                            'leader',
                            'members' => function($q) {
                                $q->orderBy('joined_scan_at');
                            }
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
        return $this->hasMany(User::class, 'id_scanlator')->select('id', 'name', 'email', 'id_scanlator', 'joined_scan_at', 'role', 'scan_role');
    }

    public function leader()
    {
        return $this->belongsTo(User::class, 'id_leader')->select('id', 'name', 'email', 'joined_scan_at');
    }
}
