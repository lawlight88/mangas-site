<?php

namespace Database\Seeders;

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
        User::create([
            'name' => 'micael',
            'email' => 'micael@teste.com',
            'password' => bcrypt('12341234')
        ]);
        User::create([
            'name' => 'maria',
            'email' => 'maria@teste.com',
            'password' => bcrypt('12341234')
        ]);
        User::create([
            'name' => 'jose',
            'email' => 'jose@teste.com',
            'password' => bcrypt('12341234')
        ]);
    }
}
