<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
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
        $password = bcrypt('12341234');

        User::factory()->create([
            'name' => 'micael',
            'email' => 'micael@teste.com',
            'password' => $password,
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => $password,
            'role' => Role::IS_ADMIN,
        ]);

        User::factory()->create([
            'name' => 'Jose',
            'email' => 'jose@teste.com',
            'password' => $password,
        ]);

        User::factory()
                ->count(100)
                ->create([
                    'password' => $password
                ]);
    }
}
