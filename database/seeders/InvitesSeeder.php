<?php

namespace Database\Seeders;

use App\Models\Invite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i < 30; $i++) {
            Invite::create([
                'id_scanlator' => $i,
                'id_invited' => 1
            ]);
            // Invite::create([
            //     'id_scanlator' => $i,
            //     'id_invited' => 3
            // ]);
        }
    }
}
