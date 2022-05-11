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
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public static function checkIfAlreadyRequested(int $id_requester, int $id_manga)
    {
        $request = \App\Models\Request::where('id_requester', $id_requester)
                                        ->where('id_manga', $id_manga)
                                        ->first();
        if(empty($request))
            return null;
        return true;
    }
}
