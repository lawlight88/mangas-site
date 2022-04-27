<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateMangaRequest;
use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $pages = $request->pages; //ch
        $data = $request->except('_token', 'genres', 'pages');
        $data['ongoing'] = isset($data['ongoing']);
        $data['genres'] = Manga::convertGenreKey($request->genres);
        $data['genres'] = implode('#', $data['genres']);
        $data['id'] = Manga::genId();

        foreach($pages as $key => $page) {
            $ext = $page->getClientOriginalExtension();
            $pages[$key] = $page->storeAs("{$data['id']}/chapter_1", "page_". ($key+1) .".$ext");
        }

        Manga::create($data);
        
        return redirect()->route('app.index');
    }

    public function details(int $id)
    {
        dd(Manga::genId());
        dd(Manga::find($id));
    }
}
