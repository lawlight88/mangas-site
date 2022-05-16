<?php

namespace Database\Seeders;

use App\Models\Scanlator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScanlatorsSeeder extends Seeder
{
    public function run()
    {
        Scanlator::factory()
                    ->count(20)
                    ->create();
    }
}
