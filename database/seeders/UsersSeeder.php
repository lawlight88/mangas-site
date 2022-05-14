<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Scanlator;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'micael',
            'email' => 'micael@teste.com',
            'password' => bcrypt('12341234'),
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12341234'),
            'role' => Role::IS_ADMIN,
        ]);

        User::factory()
                ->has(
                    Scanlator::factory()
                                ->state(function(array $attributes, User $user) {
                                    return ['id_leader' => $user->id];
                                })
                )
                ->state([
                    'name' => 'Jose',
                    'email' => 'jose@teste.com',
                    'password' => bcrypt('12341234'),
                    'role' => Role::IS_SCAN_LEADER,
                    'scan_role' => 'Leader',
                ])
                ->create();

        User::factory()
                ->count(100)
                ->create([
                    'password' => bcrypt('12341234')
                ]);
    }
}
