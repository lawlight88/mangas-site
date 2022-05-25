<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store(Manga $manga)
    {
        if(Favorite::isMangaOnFavorites(Auth::id(), $manga->id))
            return back();

        Favorite::create([
            'id_user' => Auth::id(),
            'id_manga' => $manga->id
        ]);

        return back();
    }

    public function remove(Manga $manga)
    {
        if(!$favorite = Favorite::getByUserManga(Auth::id(), $manga->id))
            return back();

        $favorite->delete();

        return back();
    }

    public function view()
    {
        $favorites = Favorite::forView();
        return view('user.favorite_mangas', compact('favorites'));
    }
}
