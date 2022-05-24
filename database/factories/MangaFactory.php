<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\Manga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manga>
 */
class MangaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->unique()->words(3, true)),
            'author' => $this->faker->name,
            'id' => $this->faker->unique()->randomNumber(5, true),
            'desc' => $this->faker->paragraph(),
            'ongoing' => random_int(0, 1),
            'cover' => 'img/favicon.png'
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function(Manga $manga) {
            $qty_genres = random_int(1, 10);
            $genres_keys = (array) array_rand(array_keys(Manga::$genres), $qty_genres);
            foreach($genres_keys as $genre_key) {
                Genre::create([
                    'id_manga' => $manga->id,
                    'genre_key' => $genre_key
                ]);
            }
        });
    }
}
