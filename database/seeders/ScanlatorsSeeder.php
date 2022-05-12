<?php

namespace Database\Seeders;

use App\Models\Scanlator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScanlatorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 10; $i < 40; $i++) {
            Scanlator::create([
                'id_leader' => $i,
                'name' => "scan#$i",
                'image' => 'img/favicon.png'
            ]);
        }
    }
}
