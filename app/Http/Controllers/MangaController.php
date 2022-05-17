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
        return view('manga.management.create_manga', compact('user', 'genres'));
    }

    public function store(StoreUpdateMangaRequest $request)
    {
        $data = $request->except('_token', 'genres');
        $data['ongoing'] = isset($data['ongoing']);
        $data['genres'] = Manga::convertGenreKey($request->genres);
        $data['genres'] = implode('#', $data['genres']);
        $data['id'] = Manga::genId();

        if($cover = $request->cover) {
            $ext = $cover->extension();
            $cover_path = $cover->storeAs("mangas/{$data['id']}", "cover.$ext");
            $data['cover'] = "storage/$cover_path";
        }

        Manga::create($data);

        return redirect()->route('manga.index'); //change
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

        $manga->orderedChaptersPaginate();

        return view('manga.management.scan_manga_edit', compact('manga'));
    }

}
