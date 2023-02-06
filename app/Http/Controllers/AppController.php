<?php

namespace App\Http\Controllers;

use App\Utils\CacheNames;
use App\Models\Manga;
use App\Models\Request as ModelsRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function index()
    {
        $page = (int) request()->get('page') ?? 1;
        $mangas_pop = cache()->remember(CacheNames::mangasPopular(), 60*5, fn() => Manga::popularNow()->get());
        $mangas_new = cache()->remember(CacheNames::mangasNew($page), 60*5, fn() => Manga::latestUpdatedPaginate());

        $user = null;
        if(Auth::check())
            $user = Auth::user();
        
        return view('index', compact('mangas_pop', 'mangas_new', 'user'));
    }

    public function mangaMain(int $id)
    {
        if(!$manga = cache()->remember(CacheNames::mangaMain($id), 60*10, fn() => Manga::withChaptersScanGenres()->find($id)))
            return back();

        $mangas_like_this = cache()->remember(CacheNames::mangaLike($id), 60*10, fn() => $manga->likeThis()->limit(8)->get());
        $manga->convertGenresKeys();
        
        $requested = null;
        if(Auth::check() && Auth::user()->role == Role::IS_SCAN_LEADER && is_null($manga->scanlator))
            $requested = ModelsRequest::checkIfAlreadyRequested(id_requester: Auth::user()->id_scanlator, id_manga: $id);

        return view('manga.main', compact('manga', 'requested', 'mangas_like_this'));
    }

    public function mangaView(int $id, int $chapter_order, int $page_order = 1, int $id_comment_edit = null)
    {
        if(!$manga = cache()->remember(CacheNames::mangaChapterOrder($id, $chapter_order), 60*60, fn() => Manga::mangaViewQuery($chapter_order)->find($id)))
            return back();

        if(!$page = $manga->pages->where('order', $page_order)->first())
            return back();

        $chapter = $manga->chapters->first();
        $expires_at = now()->addDay();

        views($manga)
            ->cooldown($expires_at)
            ->record();
        views($chapter)
            ->cooldown($expires_at)
            ->record();
        if($manga->scanlator)
        {
            views($manga->scanlator)
                ->cooldown($expires_at)
                ->record();
        }
        
        $comments = cache()->remember(CacheNames::chapterComments($chapter->id), 60*60, fn() => $manga->chapters->first()->commentsWithUsers());

        return view('manga.chapter', compact('manga', 'page', 'chapter_order', 'comments', 'id_comment_edit'));
    }

    public function genres()
    {
        $genres = Manga::$genres_list;
        return view('genres', compact('genres'));
    }

    public function genre(int $genre_key)
    {
        $genres = Manga::$genres_list;

        if(!in_array($genre_key, array_keys($genres)))
            return back();

        $mangas = Manga::paginateByGenre($genre_key);
        $genre = $genres[$genre_key];

        return view('genre_mangas', compact('mangas', 'genre'));
    }

    public function random()
    {
        $id_manga = Manga::select('id')->has('chapters')->inRandomOrder()->first()->id;
        return redirect()->route('app.manga.main', $id_manga);
    }

    public function search(Request $req)
    {
        $mangas = Manga::searchBy($req->search);
        return view('manga.search', compact('mangas'));
    }

    public function moreLikeThis(Manga $manga_base)
    {
        $mangas = $manga_base->likeThis()->paginate(25);
        return view('more_like_this', compact('manga_base', 'mangas'));
    }
}
