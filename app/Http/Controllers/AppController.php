<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function index()
    {
        $mangas = Manga::with('chapters')->get();
        foreach($mangas as $manga) {
            $covers_path[] = $manga->chapters()->first()->path . '/1.png';
        }

        $user = null;
        if(Auth::check())
            $user = Auth::user();
        
        return view('index', compact('covers_path', 'user'));
    }
}
