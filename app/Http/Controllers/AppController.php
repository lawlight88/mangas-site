<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Mime\Encoder\Base64Encoder;

use function PHPUnit\Framework\isTrue;

class AppController extends Controller
{
    public function index()
    {
        $covers_pop = [];
        

        $user = null;

        if(Auth::check())
            $user = Auth::user();
        
        return view('index', compact('covers_pop', 'user'));
        // return view('index');
    }
}
