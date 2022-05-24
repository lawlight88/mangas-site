<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\Request as ModelsRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function index()
    {
        $mangas_pop = Manga::getIndexMangas(limit:5, skip:0); //
        $mangas_new = Manga::latestUpdatedPaginate();

        $user = null;
        if(Auth::check())
            $user = Auth::user();
        
        return view('index', compact('mangas_pop', 'mangas_new', 'user'));
    }

    public function mangaMain(int $id)
    {
        if(!$manga = Manga::withChaptersScanGenres()->find($id))
            return back();

        $manga->convertGenresKeys();
        
        $requested = null;
        if(Auth::check() && Auth::user()->role == Role::IS_SCAN_LEADER && is_null($manga->scanlator))
            $requested = ModelsRequest::checkIfAlreadyRequested(id_requester: Auth::user()->id_scanlator, id_manga: $id);

        return view('manga.main', compact('manga', 'requested'));
    }

    public function mangaView(int $id, int $chapter_order, int $page_order = 1, int $id_comment_edit = null)
    {
        if(!$manga = Manga::mangaViewQuery($chapter_order, $page_order)->find($id))
            return back();

        if(!$page = $manga->pages->first())
            return back();
        
        $comments = $manga->chapters->first()->comments;

        return view('manga.chapter', compact('manga', 'page', 'chapter_order', 'comments', 'id_comment_edit'));
    }

    public function genres()
    {
        $genres = Manga::$genres;
        return view('genres', compact('genres'));
    }

    public function genre(int $genre_key)
    {
        $genres = Manga::$genres;

        if(!in_array($genre_key, array_keys($genres)))
            return back();

        dd(Manga::whereHas('genres', function($q) use($genre_key) {
            $q->where('genre_key', $genre_key);
        })->get());

        dd($genres[$genre_key]);
    }
}
