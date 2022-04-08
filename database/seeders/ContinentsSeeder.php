<?php

namespace Database\Seeders;

use App\Models\Continent;
use Illuminate\Database\Seeder;

class ContinentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Continent::create([
            "nom_ar" => 'آسيوية',
            "nom_fr" => 'Asiatique',
        ]);
        Continent::create([
            "nom_ar" => 'أوروبية',
            "nom_fr" => 'Eurpéenne',
        ]);
        Continent::create([
            "nom_ar" => 'أمريكية',
            "nom_fr" => 'Américaine',
        ]);
    }
}
