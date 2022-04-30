<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AppController extends Controller
{
    public function index()
    {
        $mangas_pop = Manga::getIndexMangas(limit:5, skip:0);
        $mangas_new = Manga::getIndexMangas(limit:25, skip:5);
        // orderBy('updated_at', 'desc')... when store

        $pop_covers_path = Manga::getCoversPath($mangas_pop);
        $covers_path = Manga::getCoversPath($mangas_new);

        $user = null;
        if(Auth::check())
            $user = Auth::user();
        
        return view('index', compact('pop_covers_path', 'covers_path', 'user'));
    }
}
