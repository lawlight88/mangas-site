<?php

namespace Database\Seeders;

use App\Models\Role;
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
        $faker = Factory::create();

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

        User::create([
            'name' => 'jose',
            'email' => 'jose@teste.com',
            'password' => bcrypt('12341234')
        ]);

        for($i = 0; $i < 100; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => $faker->email(),
                'password' => bcrypt('12341234')
            ]);
        }
    }
}
