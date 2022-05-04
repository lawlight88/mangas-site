<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function index()
    {
        $mangas_pop = Manga::getIndexMangas(limit:5, skip:0); //
        $mangas_new = Manga::getIndexMangas(limit:5, skip:5); //
        // orderBy('updated_at', 'desc')... when store //

        $mangas_pop = Manga::getCoverPathAndId($mangas_pop);
        $mangas_new = Manga::getCoverPathAndId($mangas_new);

        $user = null;
        if(Auth::check())
            $user = Auth::user();
        
        return view('index', compact('mangas_pop', 'mangas_new', 'user'));
    }

    public function mangaMain(int $id)
    {
        if(!$manga = Manga::with('chapters.pages')->find($id)) //
            return back();

        $cover = Manga::getCoverPath($manga);
        
        $manga->genres = explode('#', $manga->genres);

        $manga->chapters = $manga->chapters()->orderBy('order', 'asc')->get();

        return view('manga.main', compact('manga', 'cover'));
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
}
