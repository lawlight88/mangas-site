<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_manga',
        'id_user'
    ];

    public $timestamps = false;

    public static function isMangaOnFavorites(int $id_user, int $id_manga)
    {
        $favorite = Favorite::getByUserManga($id_user, $id_manga);

        return empty($favorite) ? false : true;
    }

    public static function getByUserManga(int $id_user, int $id_manga)
    {
        return Favorite::where(['id_user' => $id_user, 'id_manga' => $id_manga])
                            ->first();
    }

    public static function forView()
    {
        return Favorite::where('id_user', Auth::id())
                        ->with('manga:name,id,cover')
                        ->orderBy('id', 'desc')
                        ->paginate(25);
    }

    public function manga()
    {
        return $this->belongsTo(Manga::class, 'id_manga');
    }
}
