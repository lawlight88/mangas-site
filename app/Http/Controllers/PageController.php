<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageOrderUpdateRequest;
use App\Http\Requests\PageStoreRequest;
use App\Models\Chapter;
use App\Models\Manga;
use App\Models\Page;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function orderOnUpload(Manga $manga, PageOrderUpdateRequest $req)
    {
        $this->authorize('orderOnUpload', [Page::class, $manga]);

        $orders = $req->validated()['orders'];
        foreach ($orders as $old_order => $new_order) {
            $old_path = Storage::disk('temp')->files("$manga->id/$old_order")[0];
            $new_path = str_replace("/$old_order/", "/$new_order/", $old_path);
            Storage::disk('temp')->move($old_path, $new_path);
        }

        return redirect()->route('chapter.upload.continue', $manga);
    }

    public function orderOnEditAndName(Chapter $chapter, PageOrderUpdateRequest $req)
    {
        $this->authorize('orderOnEdit', [Page::class, $chapter]);

        $orders = $req->validated()['orders'];
        $chapter->updatePagesOrders($orders);

        if ($req->filled('name')) {
            $this->validate($req, ['name' => 'string|min:1|max:30']);
            $chapter->update(['name' => $req->name]);
        }

        return back();
    }

    public function removeOnUpload(Manga $manga, int $order)
    {
        $this->authorize('removeOnUpload', [Page::class, $manga]);

        $total_pages = count(Storage::disk('temp')->allFiles($manga->id));
        $resting_pages = $total_pages - $order;

        $file = Storage::disk('temp')->files("$manga->id/$order")[0];
        Storage::disk('temp')->delete($file);

        if ($resting_pages > 0) {
            for ($i = ++$order; $i <= $total_pages; $i++) {
                $file_old_path = Storage::disk('temp')->files("$manga->id/$i")[0];
                $file_new_path = str_replace("/$i/", '/' . ($i - 1) . '/', $file_old_path);
                Storage::disk('temp')->move($file_old_path, $file_new_path);
            }
        }

        Storage::disk('temp')->deleteDirectory("$manga->id/$total_pages");

        return redirect()->route('chapter.upload.continue', $manga);
    }

    public function removeOnEdit(Chapter $chapter, int $order)
    {
        $this->authorize('removeOnEdit', [Page::class, $chapter]);

        if (!in_array($order, range(1, $chapter->pages->count())) || $chapter->pages->count() <= 2) {
            return back();
        }

        $page = $chapter->getPageByOrder($order);
        $path = str_replace('storage/', '', $page->path);

        Storage::delete($path);
        $page->delete();

        $chapter->rearrangePagesOrder(removed_page_order: $order);

        return back();
    }

    public function addOnUpload(Manga $manga, PageStoreRequest $req)
    {
        $this->authorize('addOnUpload', [Page::class, $manga]);

        $pages = $req->validated()['pages'];
        $qty_files = count(Storage::disk('temp')->allFiles($manga->id));
        foreach ($pages as $page) {
            Storage::disk('temp')->put("$manga->id/" . ++$qty_files, $page);
        }

        return redirect()->route('chapter.upload.continue', $manga);
    }

    public function addOnEdit(Chapter $chapter, PageStoreRequest $req)
    {
        $this->authorize('addOnEdit', [Page::class, $chapter]);

        $chapter->addPagesOnEdit($req->validated()['pages']);

        return back();
    }

    public function display(Manga $manga, int $order)
    {
        $this->authorize('display', [Page::class, $manga]);

        $file = Storage::disk('temp')->files("$manga->id/$order")[0];
        $filepath = config('filesystems.disks.temp.root') . "/$file";
        return response()->file($filepath);
    }
}
