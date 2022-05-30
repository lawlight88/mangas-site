<?php

namespace App\Http\Controllers;

use App\Http\Requests\MangaStoreRequest;
use App\Http\Requests\MangaUpdateRequest;
use App\Models\Genre;
use App\Models\Manga;
use Illuminate\Support\Facades\Storage;

class MangaController extends Controller
{
    public function create() 
    {
        $this->authorize('create', Manga::class);
        $genres = Manga::$genres;
        return view('manga.management.create_manga', compact('genres'));
    }

    public function store(MangaStoreRequest $req)
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

    public function editInfo(Manga $manga)
    {
        $this->authorize('editInfo', $manga);

        $genres = Manga::$genres;
        $manga->genres;
        $manga_genres = $manga->genres->pluck('genre_key')->toArray();

        return view('manga.management.edit_info_manga', compact('genres', 'manga', 'manga_genres'));
    }

    public function updateInfo(Manga $manga, MangaUpdateRequest $req)
    {
        $this->authorize('editInfo', $manga);

        $data = $req->except('genres');
        $data['ongoing'] = isset($data['ongoing']);

        if($req->cover)
        {
            $coverpath = $manga->cover;
            $coverpath = str_replace('storage/', '', $coverpath); 
            Storage::delete($coverpath);

            $new_cover = $req->cover;
            $ext = $new_cover->extension();
            $new_cover_path = $new_cover->storeAs("mangas/$manga->id", "cover.$ext");
            $data['cover'] = "storage/$new_cover_path";
        }

        $manga->update($data);
        $manga->updateGenres($req->genres);

        return redirect(route('scan.mangas', $manga->id_scanlator)."?search=$manga->name");
    }
}
