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
        $text = 'manga';
        $text2 = 'chapter_1';
        // $string = $text;                                            
        $font   = 3;
        $width  = 175;
        // $width  = ImageFontWidth($font) * strlen($string);
        $height = 200;
        // $height = ImageFontHeight($font);

        $covers_pop = [];
        
        // for($i = 0; $i < 7; $i++) {
        //     $im = @imagecreate ($width,$height);
        //     $background_color = imagecolorallocate ($im, 255, 255, 255); //white background
        //     $text_color = imagecolorallocate ($im, 0, 0,0);//black text
        //     $text .= "#$i";
        //     imagestring ($im, $font, 5, 5, $text, $text_color);
        //     imagestring ($im, $font, 5, 20, $text2, $text_color);
        //     // ob_start();
        //     if(!file_exists('storage/tests/teste'))
        //         mkdir('storage/tests/teste', 0777, true);

        //     imagepng($im, "storage/tests/teste/t-$i.png");

        //     // $imstr = base64_encode(ob_get_clean());
        //     // $covers_pop[] = $imstr;
        //     imagedestroy($im);
        //     $text = str_replace("#$i", '', $text);
        // }

        $user = null;

        if(Auth::check())
            $user = Auth::user();
        
        return view('index', compact('covers_pop', 'user'));
        // return view('index');
    }
}
