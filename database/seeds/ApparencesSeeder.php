<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ApparencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('apparences')->insert([
            'label' => 'Akountia',
            'title' => 'Akountia',
            'logo_titre' => 'Akountia',
            'layout' => 'verticalmoderne',
            'logo' => '/assets/img/logo/small_logo_afrique-academy.svg',
            'logo_home' => '/assets/img/logo/logo_home_afrique-academy.svg',
            'couleur_header' => '#ffffff',
            'couleur_sidebar' => '#2c323f',
            'couleur_sidebar_logo' => '#2c323f',
            'statut' => '1',
        ]);
    }
}
