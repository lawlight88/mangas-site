<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Manga extends Model
{
    use HasFactory;

    public static $genres = [
        'action',
        'adventure',
        'historical',
        'adult',
        'horror',
        'josei',
        'comedy',
        'martial art',
        'drama',
        'mature',
        'mecha',
        'mystery',
        'one shot',
        'psychological',
        'romance',
        'ecchi',
        'fantasy',
        'gender bender',
        'harem',
        'sports',
        'supernatural',
        'tragedy',
        'yuri',
        'shotacon',
        'school life',
        'sci-fi',
        'shoujo',
        'shoujo ai',
        'shounen',
        'shounen ai',
        'slice of life',
        'seinen',
        'isekai',
    ];

    protected $fillable = [
        'name',
        'ongoing',
        'author',
        'genres',
        'desc',
        'id',
        // 'chapters',
    ];

    protected $casts = [
        'chapters' => 'integer',
        'ongoing' => 'boolean',
    ];

    public static function genId()
    {
        $id = [
            'id' => rand(100000, 999999)
        ];

        $rules = ['id' => 'unique:mangas'];

        $validate = Validator::make($id, $rules);

        return $validate ? $id['id'] : Manga::genId();
    }

    public static function convertGenreKey(array $data_genres)
    {
        $genres = self::$genres;
        $genres_converted = [];

        foreach($data_genres as $genre_key) {
            foreach($genres as $key2 => $genre) {
                if($genre_key == $key2) {
                    $genres_converted[] = $genre;
                    break;
                }
            }
        }

        return $genres_converted;
    }

    public static function getCoversPath(Collection $mangas)
    {
        foreach($mangas as $manga) {
            $paths[] = $manga->chapters()
                            ->where('chapters.order', 1)
                            ->first()
                                ->pages()
                                ->where('pages.order', 1)
                                ->first()->path;
        }
        return $paths;
    }

    public static function getIndexMangas(int $limit = 25, int $skip = 0) {
        return Manga::with(['chapters' => function($q) {
            $q->where('order', 1);
        }, 'chapters.pages' => function($q) {
            $q->where('order', 1);
        }])->limit($limit)->skip($skip)->get();
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'id_manga');
    }
    
    public function pages()
    {
        return $this->hasManyThrough(Page::class, Chapter::class, 'id_manga', 'id_chapter');
    }
}
