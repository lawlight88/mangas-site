<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageStoreRequest;
use App\Models\Chapter;
use App\Models\Manga;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChapterController extends Controller
{
    public function edit(Chapter $chapter)
    {
        $this->authorize('edit', $chapter);

        $chapter->pages;

        return view('manga.management.chapter_upload', compact('chapter'));
    }

    public function delete(Chapter $chapter)
    {
        $this->authorize('delete', $chapter);

        Storage::deleteDirectory($chapter->getPath());

        $chapter->delete();

        return back();
    }

    public function uploadPreview(Manga $manga, PageStoreRequest $req)
    {
        $this->authorize('uploadChapter', $manga);
        
        Storage::disk('temp')->deleteDirectory($manga->id);

        $pages = $req->file('pages');
        foreach($pages as $key => $page) {
            Storage::disk('temp')->put("$manga->id/".++$key, $page);
        }
        
        return redirect()->route('chapter.upload.continue', $manga);
    }

    public function upload(Manga $manga)
    {
        $this->authorize('uploadChapter', $manga);

        $chapters = Storage::directories("mangas/$manga->id");
        $last_chapter = count($chapters);
        $upload_chapter_order = ++$last_chapter;

        $n_upload_pages = count(Storage::disk('temp')->allFiles($manga->id));
        if($n_upload_pages < 2)
            return back();

        Chapter::upload(
            manga: $manga,
            upload_chapter_order: $upload_chapter_order,
            n_upload_pages: $n_upload_pages,
        );

        Storage::disk('temp')->deleteDirectory($manga->id);

        return redirect()->route('manga.edit', $manga);
    }

    public function continueUpload(Manga $manga)
    {
        $this->authorize('uploadChapter', $manga);

        if(!$qty_temp_files = count(Storage::disk('temp')->allFiles($manga->id)))
            return back();

        return view('manga.management.chapter_upload', compact('qty_temp_files', 'manga'));
    }

    public function cancelUpload(Manga $manga)
    {
        $this->authorize('cancelUpload', $manga);

        Storage::disk('temp')->deleteDirectory($manga->id);

        return redirect()->route('manga.edit', $manga);
    }
}
