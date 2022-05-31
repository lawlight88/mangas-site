<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Manga;
use App\Models\Page;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        
        for($i = 1; $i <= 10; $i++) {
            $id = Manga::genId();

            $m_title= "example-manga?id=$id";

            //cover
            $m_path = public_path() . "/storage/mangas/$id";
            $m_name = "Manga#$id";
            $cover_text = "cover";
            $im = @imagecreate ($width,$height);

            imagecolorallocate ($im, 255, 255, 255); //white background
            $text_color = imagecolorallocate ($im, 0, 0,0);//black text

            imagettftext($im, $size, 0, 110, 800, $text_color, $font, $m_name);
            imagettftext($im, $size, 0, 110, 900, $text_color, $font, $cover_text);

            mkdir($m_path, 0777, true);
            $cover_path = "$m_path/cover.png";
            imagepng($im, $cover_path);
            imagedestroy($im);
            //end cover

            Manga::factory()
                    ->create([
                        'id' => $id,
                        'cover' => str_replace(public_path().'/', '', $cover_path),
                    ]);

            $number_of_chapters = random_int(1, 5);

            for($b = 1; $b <= $number_of_chapters; $b++) {
                $m_chapter = "Chapter_$b";
                $path = public_path()."/storage/mangas/$id/$m_chapter";


                $number_of_pages = random_int(5, 10);

                $chapter = Chapter::create([
                    'name' => str_replace('_', ' ', $m_chapter),
                    'id_manga' => $id,
                    'order' => $b,
                ]);
                $chapter->manga->update(['last_chapter_uploaded_at' => now()]);
                
                $id_chapter = $chapter->id;

                for($c = 1; $c <= $number_of_pages; $c++) {
                    $m_page = "page_$c";
                    $im = @imagecreate ($width,$height);

                    imagecolorallocate ($im, 255, 255, 255); //white background
                    $text_color = imagecolorallocate ($im, 0, 0,0);//black text

                    imagettftext($im, $size, 0, 110, 800, $text_color, $font, $m_title);
                    imagettftext($im, $size, 0, 110, 900, $text_color, $font, $m_chapter);
                    imagettftext($im, $size, 0, 110, 1000, $text_color, $font, $m_page);

                    if(!file_exists($path))
                        mkdir($path, 0777, true);
                    $path_page = "$path/$c.png";
                    imagepng($im, $path_page);
                    imagedestroy($im);

                    Page::create([
                        'order' => $c,
                        'id_chapter' => $id_chapter,
                        'path' => str_replace(public_path().'/', '', $path_page),
                    ]);
                }
            }

        }
    }
}
