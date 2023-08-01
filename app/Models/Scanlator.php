<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\Support\Period;

class Scanlator extends Model implements Viewable
{
    use InteractsWithViews;
    use HasFactory;

    protected $removeViewsOnDelete = true;

    protected $fillable = [
        'name',
        'image',
        'desc',
        'id_leader',
    ];

    public static function getIndexScans()
    {
        return Scanlator::select('id', 'name', 'image', 'created_at')
                        ->orderByViews('desc', Period::subWeeks(1))
                        ->paginate(25);
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

    public function membersPaginate()
    {
        return User::where('id_scanlator', $this->id)
                            ->orderBy('joined_scan_at')
                            ->paginate(25);
    }

    public static function withScanInfo()
    {
        return Scanlator::with([
                                'leader',
                                'mangas' => function($q) {
                                    $q->select('id', 'name', 'id_scanlator')
                                        ->limit(3);
                                }
                            ])
                            ->withCount('mangas');
    }

    public function mangasPaginate()
    {
        $mangas = $this->mangas()
                        ->orderByViews()
                        ->paginate(5);

        foreach($mangas as $manga) {
            $manga->getViews();
        }

        return $mangas;
    }

    public function searchMangas(string $search)
    {
        $mangas = $this->mangas()
                        ->where('name', 'like', "%$search%")
                        ->orWhere('author', 'like', "%$search%")
                        ->orderByViews('desc', Period::subWeeks(1))
                        ->paginate(5);

        foreach($mangas as $manga) {
            $manga->getViews();
        }

        return $mangas;
    }

    public function mangas()
    {
        return $this->hasMany(Manga::class, 'id_scanlator');
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
