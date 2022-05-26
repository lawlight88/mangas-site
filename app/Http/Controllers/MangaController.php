<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateMangaRequest;
use App\Models\Genre;
use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MangaController extends Controller
{
    public function create() 
    {
        $genres = Manga::$genres;
        $user = Auth::user();
        return view('manga.management.create_manga', compact('user', 'genres'));
    }

    public function store(StoreUpdateMangaRequest $req)
    {
        $data = $req->except('genres');
        $data['ongoing'] = isset($data['ongoing']);
        $data['id'] = Manga::genId();

        $cover = $req->cover;
        $ext = $cover->extension();
        $cover_path = $cover->storeAs("mangas/{$data['id']}", "cover.$ext");
        $data['cover'] = "storage/$cover_path";

        $manga = Manga::create($data);

        foreach($req->genres as $genre_key) {
            Genre::create([
                'id_manga' => $manga->id,
                'genre_key' => $genre_key
            ]);
        }

        return redirect()->route('app.index');
    }

    public function removeFromScan(Manga $manga)
    {
        $this->authorize('removeFromScan', $manga);

        $manga->update([
            'id_scanlator' => null
        ]);
        
        return back();
    }

    public function edit(Manga $manga)
    {
        $this->authorize('edit', $manga);

        $manga->chaptersPaginateViews();

        return view('manga.management.scan_manga_edit', compact('manga'));
    }
}
