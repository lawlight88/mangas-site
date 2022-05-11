<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_requester',
        'id_manga',
        'status',
        'visible_admin',
        'visible_scan',
    ];

    protected $casts = [
        'status' => 'boolean',
        'visible_admin' => 'boolean',
        'visible_scan' => 'boolean',
    ];

    public static function checkIfAlreadyRequested(int $id_requester, int $id_manga)
    {
        $request = Request::where('id_requester', $id_requester)
                                        ->where('id_manga', $id_manga)
                                        ->first();
        if(empty($request))
            return null;
        return true;
    }

    public function manga()
    {
        return $this->belongsTo(Manga::class, 'id_manga');
    }
}
