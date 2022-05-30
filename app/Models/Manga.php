<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\Support\Period;
use stdClass;

class Manga extends Model implements Viewable
{
    use HasFactory;
    use InteractsWithViews;

    public $_views;
    protected $removeViewsOnDelete = true;

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

    public $incrementing = false;

    public function __construct()
    {
        $this->_views = new stdClass;
    }

    public static function genId()
    {
        $id = [
            'id' => rand(100000, 999999)
        ];

        $rules = ['id' => 'unique:mangas'];

        $validate = Validator::make($id, $rules);

        return $validate ? $id['id'] : Manga::genId();
    }

    public function convertGenresKeys()
    {
        $genres_models = $this->genres;
        $genres_list = self::$genres;
        $converted_genres = [];
        foreach($genres_models as $genre_model) {
            if(isset($genres_list[$genre_model->genre_key]))
                $converted_genres[$genre_model->genre_key] = $genres_list[$genre_model->genre_key];
        }
        $this->genres = $converted_genres;
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

    public static function withChaptersScanGenres()
    {
        return Manga::with('chapters', 'scanlator', 'genres');
    }

    public function chaptersPaginateViews()
    {
        $this->chapters = Chapter::where('id_manga', $this->id)
                                    ->orderBy('order', 'asc')
                                    ->paginate(10);

        foreach($this->chapters as $chapter) {
            $chapter->getViews();
        }
    }

    public static function mangaViewQuery(int $chapter_order, int $page_order)
    {
        return Manga::query()->select('id', 'name', 'id_scanlator')
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
            },
                'scanlator:id'
        ]);
    }

    public static function paginateByGenre(int $genre_key)
    {
        return Manga::whereHas('genres', function($q) use($genre_key) {
                        $q->where('genre_key', $genre_key);
                    })
                    ->orderByViews('desc', Period::subWeeks(1))
                    ->paginate(25);
    }

    public static function searchBy(string $search)
    {
        return Manga::where('name', 'like', "%$search%")
                        ->orWhere('author', 'like', "%$search%")
                        ->orderByViews('desc', Period::subWeeks(1))
                        ->paginate(25);
    }

    public function getViews()
    {
        $this->_views->total = views($this)
                                ->count();

        $this->_views->month = views($this)
                                ->period(Period::subMonths(1))
                                ->count();  

        $this->_views->week = views($this)
                                ->period(Period::subWeeks(1))
                                ->count();
                                
        $this->_views->today = views($this)
                                ->period(Period::subDays(1))
                                ->count();

        return $this->_views;
    }

    public function updateGenres(array $req_genres)
    {
        $manga_prev_genres = $this->genres->pluck('genre_key')->toArray();
        $new_genres = array_diff($req_genres, $manga_prev_genres);
        
        $this->genres()->whereNotIn('genre_key', $req_genres)
                        ->delete();

        if($new_genres)
        {
            foreach($new_genres as $new_genre)
            {
                $new_genre_arrays[] = ['genre_key' => $new_genre];
            }
            $this->genres()->createMany($new_genre_arrays);
        }
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
        return $this->hasMany(Chapter::class, 'id_manga')->orderBy('order')->orderBy('order', 'asc');
    }
    
    public function pages()
    {
        return $this->hasManyThrough(Page::class, Chapter::class, 'id_manga', 'id_chapter');
    }

    public function genres()
    {
        return $this->hasMany(Genre::class, 'id_manga');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'id_manga')->orderBy('id', 'desc');
    }
}