<?php

namespace Database\Factories;

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
            'genres' => Manga::genRandomGenres(),
            'cover' => 'img/favicon.png'
        ];
    }
}
