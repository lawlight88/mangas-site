<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageOrderUpdateRequest;
use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function orderOnUpload(Manga $manga, PageOrderUpdateRequest $req)
    {
        $this->authorize('orderPagesOnUpload', $manga);

        $orders = $req->orders;
        $temp_dir = $manga->getTempFolderPath();
        foreach($orders as $old_order => $new_order) {
            $old_paths[$old_order] = Storage::files("$temp_dir/$old_order")[0];
        }

        foreach($orders as $old_order => $new_order) {
            $new_path = str_replace("/$old_order/", "/$new_order/", $old_paths[$old_order]);
            Storage::move($old_paths[$old_order], $new_path);
            $paths[$new_order] = "storage/$new_path";
        }

        ksort($paths);

        return view('manga.management.chapter_upload', compact('paths', 'manga'));
    }

    public function removeOnUpload(Manga $manga, int $order)
    {
        $this->authorize('removePagesOnUpload', $manga);

        $temp_dir = $manga->getTempFolderPath();
        $total_pages = count(Storage::allFiles($temp_dir));
        $resting_pages = $total_pages - $order;

        $files = Storage::files("$temp_dir/$order");
        Storage::delete($files);

        if($resting_pages > 0) {
            for($i = ++$order; $i <= $total_pages; $i++) {
                $file_old_path = Storage::files("$temp_dir/$i")[0];
                $file_new_path = str_replace("/$i/", '/'.($i - 1).'/', $file_old_path);
                Storage::move($file_old_path, $file_new_path);
            }
        }

        Storage::deleteDirectory("$temp_dir/$total_pages");

        return redirect()->route('chapter.upload.continue', $manga);
    }
}
