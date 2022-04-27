<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MangaController extends Controller
{
    public function __construct(public Manga $manga)
    {}
    public function create() 
    {
        $genres = $this->manga->genres;
        $user = Auth::user();
        return view('manga.create', compact('user', 'genres'));
    }
}
