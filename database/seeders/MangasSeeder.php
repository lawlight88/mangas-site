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

            $genre_key_array = array_rand(Manga::$genres, random_int(2, 7));
            $genres = Manga::convertGenreKey($genre_key_array);
            $one_shot = in_array('one shot', $genres) ? false : null;
            $genres = implode('#', $genres);

            $m_title= "example-manga#$id";

            $number_of_chapters = is_null($one_shot) ? random_int(3, 5) : 1;

            //cover
            $m_path = public_path() . "/storage/mangas/$id";
            $m_name = "manga#$i";
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

            Manga::create([
                'name' => "manga#$i",
                'id' => $id,
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quid censes in Latino fore? Quorum sine causa fieri nihil putandum est. Ille enim occurrentia nescio quae comminiscebatur; Duo Reges: constructio interrete. Ergo illi intellegunt quid Epicurus dicat, ego non intellego? Illa argumenta propria videamus, cur omnia sint paria peccata. Graece donan, Latine voluptatem vocant.',
                'author' => $faker->name(),
                'ongoing' => $one_shot ?? rand(0, 1),
                'genres' => $genres,
                'cover' => str_replace(public_path().'/', '', $cover_path),
            ]);

            for($b = 1; $b <= $number_of_chapters; $b++) {
                $m_chapter = "chapter_$b";
                $path = public_path()."/storage/mangas/$id/$m_chapter";


                $number_of_pages = random_int(5, 10);

                $id_chapter = Chapter::create([
                    'name' => str_replace('_', ' ', $m_chapter),
                    'id_manga' => $id,
                    'order' => $b,
                ])->id;

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
