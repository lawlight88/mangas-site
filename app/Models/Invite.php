<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_scanlator',
        'id_invited',
        'response'
    ];

    protected $casts = [
        'response' => 'boolean'
    ];

    public static function get(int $id_scanlator, int $id_invited)
    {
        return Invite::where('id_scanlator', $id_scanlator)
                        ->where('id_invited', $id_invited)
                        ->first();
    }
}
