<?php

namespace Database\Seeders;

use App\Models\Manga;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

use function PHPUnit\Framework\fileExists;

class MangasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $size = 70;
        $width  = 1280;
        $height = 1835;
        $font = public_path('/fonts/ARIAL.TTF');
        
        for($i = 1; $i <= 5; $i++) {
            $id = Manga::genId();

            $genre_key_array = array_rand(Manga::$genres, random_int(2, 7));
            $genres = Manga::convertGenreKey($genre_key_array);
            $one_shot = in_array('one shot', $genres) ? false : null;
            $genres = implode('#', $genres);

            Manga::create([
                'name' => "manga#$i",
                'id' => $id,
                'desc' => str_replace('</p>', '', str_replace('<p>', '', (Http::get('loripsum.net/api/1/short')->body()))),
                'author' => $faker->name(),
                'ongoing' => $one_shot ?? rand(0, 1),
                'genres' => $genres,
            ]);

            $m_title= "example-manga#$id";

            $number_of_chapters = is_null($one_shot) ? random_int(3, 5) : 1;

            for($b = 1; $b <= $number_of_chapters; $b++) {
                $m_chapter = "chapter_$b";


                $number_of_pages = random_int(10, 40);

                //create chapter seed

                for($c = 1; $c <= $number_of_pages; $c++) {
                    $m_page = "page_$c";
                    $im = @imagecreate ($width,$height);

                    imagecolorallocate ($im, 255, 255, 255); //white background
                    $text_color = imagecolorallocate ($im, 0, 0,0);//black text

                    imagettftext($im, $size, 0, 110, 800, $text_color, $font, $m_title);
                    imagettftext($im, $size, 0, 110, 900, $text_color, $font, $m_chapter);
                    imagettftext($im, $size, 0, 110, 1000, $text_color, $font, $m_page);

                    $path = public_path("/storage/$id/$m_chapter");

                    if(!file_exists($path))
                        mkdir($path, 0777, true);
                    imagepng($im, "$path/$c.png");
                    imagedestroy($im);
                }
            }
        }

    }
}
