<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\MountManager;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_chapter',
        'path',
        'order',
    ];

    public $timestamps = false;

    public static function upload(Chapter $chapter, int $page_order)
    {
        $path = "mangas/$chapter->id_manga/Chapter_$chapter->order";
        $file = Storage::disk('temp')->files("$chapter->id_manga/$page_order")[0];
        $file_public_path = "$path/".basename($file);

        $mountManager = new MountManager([
            'temp' => Storage::disk('temp')->getDriver(),
            'public' => Storage::disk('public')->getDriver(),
        ]);
        $mountManager->move("temp://$file", "public://$file_public_path");

        Page::create([
            'order' => $page_order,
            'id_chapter' => $chapter->id,
            'path' => "storage/$file_public_path",
        ]);
    }

    public static function checkOrders(array $orders, int $max)
    {
        if($max > 100)
            $max = 100;
        $range = range(1, $max);
        $keys = array_keys($orders);

        return in_array(min($keys), $range)
            && in_array(max($keys), $range);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'id_chapter');
    }
}
