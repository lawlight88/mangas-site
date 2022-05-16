<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\Scanlator;
use App\Models\User;
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
            'desc' => $this->faker->sentences(2, true),
            'id_leader' => User::factory()
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function(Scanlator $scan) {
            $leader = $scan->leader;
            $scan->update([
                'id_leader' => $leader->id
            ]);
            $leader->update([
                'role' => Role::IS_SCAN_LEADER,
                'scan_role' => 'Leader',
                'id_scanlator' => $scan->id
            ]);
        });
    }
}
