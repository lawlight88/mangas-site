<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
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
        'cover',
        'id_scanlator',
        'last_chapter_uploaded_at',
    ];

    protected $casts = [
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

    public static function getIndexMangas(int $limit = 25, int $skip = 0)
    {
        return Manga::skip($skip)
                    ->limit($limit)
                    ->get();
    }

    public static function latestUpdatedPaginate()
    {
        return Manga::orderBy('updated_at', 'desc')
                        ->paginate(25);
    }

    public static function withChaptersScan()
    {
        return Manga::with([
            'chapters' => function($q) {
                $q->orderBy('order', 'asc');
            },
            'scanlator',
        ]);
    }

    public function orderedChaptersPaginate()
    {
        $this->chapters = Chapter::where('id_manga', $this->id)
                                    ->orderBy('order', 'asc')
                                    ->paginate(25);
    }

    public function getTempFolderPath()
    {
        return "mangas/$this->id/temp";
    }

    public static function mangaViewQuery(int $chapter_order, int $page_order)
    {
        return Manga::query()->select('id', 'name')
            ->withCount([
                'pages' => function($q) use($chapter_order) {
                    $q->where('chapters.order', $chapter_order);
                },
                'chapters'
            ])
            ->with([
                'chapters' => function($q) use($chapter_order) {
                    $q->select('id', 'id_manga')
                        ->where('chapters.order', $chapter_order);
            },
                'pages' => function($q) use($chapter_order, $page_order) {
                    $q->select('pages.order', 'path')
                        ->where('chapters.order', $chapter_order)
                        ->where('pages.order', $page_order);
            },
                'chapters.comments' => function($q) {
                    $q->orderBy('comments.created_at', 'desc');
            },
                'chapters.comments.user' => function($q) {
                    $q->select('users.id', 'users.name', 'users.profile_image');
        }]);
    }

    public static function genRandomGenres()
    {
        $genre_key_array = array_rand(self::$genres, random_int(2, 7));
        $genres = self::convertGenreKey($genre_key_array);
        return implode('#', $genres);
    }

    public function scanlator()
    {
        return $this->belongsTo(Scanlator::class, 'id_scanlator')->select('id', 'name');
    }

    public function requests()
    {
        return $this->hasMany(\App\models\Request::class, 'id_manga');
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
