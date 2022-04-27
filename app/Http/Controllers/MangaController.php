<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateMangaRequest;
use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MangaController extends Controller
{
    public function create() 
    {
        $genres = Manga::$genres;
        $user = Auth::user();
        return view('manga.create', compact('user', 'genres'));
    }

    public function store(StoreUpdateMangaRequest $request)
    {
        $genres = Manga::$genres;

        $data = $request->except('_token', 'genres');
        $data['genres'] = [];
        $data_genres = $request->genres;

        foreach($data_genres as $genre_key) {
            foreach($genres as $key2 => $genre) {
                if($genre_key == $key2)
                    $data['genres'][] = $genre;
            }
        }
        
        dd($data);

        // create storage

        return redirect()->route('app.index');
    }
}
