<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\Support\Period;
use stdClass;

class Chapter extends Model implements Viewable
{
    use InteractsWithViews;
    use HasFactory;

    public $_views;
    protected $removeViewsOnDelete = true;

    protected $fillable = [
        'id_manga',
        'name',
        'order',
    ];

    public function getPath()
    {
        $page_path = $this->pages[0]->path;
        $file_basename = basename($page_path);

        $chapter_path = str_replace('storage/', '', $page_path);
        return str_replace("/$file_basename", '', $chapter_path);
    }

    public function getPageByOrder(int $order)
    {
        return $this->pages()
                    ->where('order', $order)
                    ->first();
    }

    public function rearrangePagesOrder(int $removed_page_order)
    {
        $this->pages()
                ->where('order', '>', $removed_page_order)
                ->decrement('order');
    }

    public function rearrangeChaptersOrder()
    {
        Chapter::where([
            ['id_manga', $this->id_manga],
            ['order', '>', $this->order]
        ])
        ->decrement('order');
    }

    public function updatePagesOrders(array $orders)
    {
        foreach($orders as $id => $order) {
            $this->pages()
                ->where('id', $id)
                ->update(['order' => $order]);
        }
    }

    public function addPagesOnEdit(array $pages)
    {
        $path = $this->getPath();
        foreach($pages as $key => $page) {
            $filepath = $page->store($path);
            Page::create([
                'id_chapter' => $this->id,
                'path' => "storage/$filepath",
                'order' => $this->pages->count() + ++$key
            ]);
        }
    }

    public static function upload(Manga $manga, int $upload_chapter_order, int $n_upload_pages, string $chapter_name)
    {
        $chapter = Chapter::create([
            'name' => $chapter_name,
            'id_manga' => $manga->id,
            'order' => $upload_chapter_order,
        ]);

        for($order = 1; $order <= $n_upload_pages; $order++) {
            Page::upload(
                chapter: $chapter,
                page_order: $order
            );
        }
    }

    public function getViews()
    {
        $this->_views = new stdClass;

        $this->_views->total = views($this)
                                ->count();

        $this->_views->month = views($this)
                                ->period(Period::pastMonths(1))
                                ->count();  

        $this->_views->week = views($this)
                                ->period(Period::pastWeeks(1))
                                ->count();
                                
        $this->_views->today = views($this)
                                ->period(Period::since(today()))
                                ->count();

        return $this->_views;
    }

    public function updateParentIfLastUploaded()
    {
        $next_chapter = Chapter::where('id_manga', $this->id_manga)
                                    ->where('created_at', '>', $this->created_at)
                                    ->orderBy('created_at', 'desc')
                                    ->first();

        if($next_chapter)
        {
            return 0;
        }
        $prev_chapter = Chapter::where('id_manga', $this->id_manga)
                                    ->where('created_at', '<', $this->created_at)
                                    ->orderBy('created_at', 'desc')
                                    ->first();
        
        if(!$prev_chapter)
        {
            $this->manga->update(['last_chapter_uploaded_at' => null]);
            return 0;
        }
        $this->manga->update(['last_chapter_uploaded_at' => $prev_chapter->created_at]);
    }

    public static function chapterComments(int $id_manga, int $chapter_order)
    {
        return Chapter::whereMangaChapterOrder($id_manga, $chapter_order)
            ->with('comments')
            ->first();
    }

    public static function whereMangaChapterOrder(int $id_manga, int $chapter_order)
    {
        return Chapter::where([
            ['id_manga', $id_manga],
            ['order', $chapter_order]
        ]);
    }

    public function manga()
    {
        return $this->belongsTo(Manga::class, 'id_manga');
    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'id_chapter')->orderBy('order');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_chapter');
    }
}
