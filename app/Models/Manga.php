<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manga extends Model
{
    use HasFactory;

    public $genres = [
        'action',
        'adventure',
        'historical',
        'adult',
        'horror',
        'josei',
        'comedy',
        'martial art',
        'drama',
        'mature',
        'mecha',
        'mystery',
        'one shot',
        'psychological',
        'romance',
        'ecchi',
        'fantasy',
        'gender bender',
        'harem',
        'sports',
        'supernatural',
        'tragedy',
        'yuri',
        'shotacon',
        'school life',
        'sci-fi',
        'shoujo',
        'shoujo ai',
        'shounen',
        'shounen ai',
        'slice of life',
        'seinen',
        'isekai',
    ];

    protected $fillable = [
        'name',
        'ongoing',
        'author',
        'genres',
        'id',
        'desc',
    ];

    protected $casts = [
        'chapters' => 'int',
        'ongoing' => 'boolean',
    ];
}
