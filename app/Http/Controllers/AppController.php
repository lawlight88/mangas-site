<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
}
