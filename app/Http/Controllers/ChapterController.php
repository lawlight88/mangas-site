<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageStoreRequest;
use App\Models\Chapter;
use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChapterController extends Controller
{
    public function edit(Chapter $chapter)
    {
        $this->authorize('edit', $chapter);

        dd(func_get_args());
    }

    public function delete(Chapter $chapter)
    {
        $this->authorize('delete', $chapter);

        dd(func_get_args());
    }

    public function upload(Manga $manga, PageStoreRequest $req)
    {
        $this->authorize('uploadChapter', $manga);

        $temp_dir = $manga->getTempFolderPath();
        Storage::deleteDirectory($temp_dir);

        $pages = $req->file('pages');
        foreach($pages as $key => $page) {
        // foreach($pages as $key => $page) {
            // $ext = $page->extension();
            // $paths[] = 'storage/' . $page->storeAs($temp_dir, ++$key.".$ext");
            $paths[++$key] = 'storage/' . $page->store("$temp_dir/$key");
        }
        
        return view('manga.management.chapter_upload', compact('paths', 'manga'));
    }

    public function continueUpload(Manga $manga)
    {
        $this->authorize('uploadChapter', $manga);

        $temp_dir = $manga->getTempFolderPath();
        if(!$qty_temp_files = count(Storage::allFiles($temp_dir)))
            return back();

        for($order = 1; $order <= $qty_temp_files; $order++) {
            $file_path = Storage::files("$temp_dir/$order")[0];
            $paths[$order] = "storage/$file_path";
        }

        return view('manga.management.chapter_upload', compact('paths', 'manga'));
    }
}
