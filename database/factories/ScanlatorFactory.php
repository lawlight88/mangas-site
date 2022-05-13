<?php

namespace Database\Factories;

use App\Models\Scanlator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Scanlator>
 */
class ScanlatorFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(),
            'desc' => $this->faker->sentences(2),
            'id_leader' => Scanlator::factory()->create()
        ];
    }
}
