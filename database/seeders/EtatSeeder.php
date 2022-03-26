<?php

namespace Database\Seeders;

use App\Models\Etat;
use Illuminate\Database\Seeder;

class EtatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Etat::create([
            'nom_fr' => 'Originale',
            'nom_ar' => 'أصليـــة'
        ]);
        Etat::create([
           'nom_fr'=> 'La casse',
           'nom_ar' => 'مستعملة'
        ]);
        Etat::create([
           'nom_fr'=> 'Copie',
           'nom_ar' => 'مقلدة'
        ]);
    }
}
