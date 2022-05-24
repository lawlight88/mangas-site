<?php

namespace Database\Factories;

use App\Models\Manga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Genre>
 */
class GenreFactory extends Factory
{
    public function definition()
    {
        return [
            'genre_key' => $this->faker->numberBetween(0, 32),
            'id_manga' => Manga::factory()
        ];
    }
}
