<?php

namespace Database\Seeders;

use App\Models\Profession;
use Illuminate\Database\Seeder;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profession::create([
            "nom_ar" => 'تاجر قطع غيار',
            "nom_fr" => 'Commerçant de pièces détachées',
        ]);
        Profession::create([
            "nom_ar" => 'ميكانيكي',
            "nom_fr" => 'Mécanicien',
        ]);
        Profession::create([
            "nom_ar" => 'كهربائي',
            "nom_fr" => 'Eléctricien',
        ]);
        Profession::create([
            "nom_ar" => 'طوليي',
            "nom_fr" => 'tôlier',
        ]);
    }
}
