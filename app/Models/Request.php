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
        'visible_scan',
    ];

    protected $casts = [
        'status' => 'boolean',
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

    public static function dontSelectVisibleColumns()
    {
        return Request::select('id', 'id_requester', 'id_manga', 'status', 'created_at', 'updated_at');
    }

    public static function pendingRequests()
    {
        return Request::dontSelectVisibleColumns()
                    ->with([
                        'manga:name,id',
                        'scanlator:name,id',
                    ])
                    ->where('status', null)
                    ->orderBy('updated_at', 'desc');
    }

    public static function adminAnsweredRequests()
    {
        return Request::dontSelectVisibleColumns()
                    ->with([
                        'manga:name,id',
                        'scanlator:name,id'
                    ])
                    ->where('status', '!=', null)
                    ->orderBy('updated_at', 'desc');
    }

    public static function answeredRequests(int $id_requester)
    {
        return Request::dontSelectVisibleColumns()
                    ->with([
                        'manga:name,id',
                    ])
                    ->where('status', '!=', null)
                    ->where('id_requester', $id_requester)
                    ->orderBy('updated_at', 'desc');
    }

    public static function countUnanswered(int $id_scan = null)
    {
        $q = Request::whereNull('status');
        if($id_scan)
            return $q->where('id_requester', $id_scan)->count();

        return $q->count();
    }

    public function manga()
    {
        return $this->belongsTo(Manga::class, 'id_manga');
    }

    public function scanlator()
    {
        return $this->belongsTo(Scanlator::class, 'id_requester');
    }
}
