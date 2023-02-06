<?php

namespace App\Models;

use App\Http\Requests\MangaStoreRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'genre_key',
        'id_manga'
    ];

    public $timestamps = false;

    public static function insertGenres(MangaStoreRequest $req, int $id_manga): void
    {
        $genres = collect($req->genres)->map(fn($genre_key) => [
                'id_manga' => $id_manga,
                'genre_key' => $genre_key
            ])->toArray();

        Genre::insert($genres);
    }
}
