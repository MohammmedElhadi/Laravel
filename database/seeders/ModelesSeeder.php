<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->loadData();
        $this->command->comment("Modeles loaded");
    }
    protected function loadData()
    {
        $this->insertModeles();
    }

    protected function insertModeles()
    {
        // Load wilayas from json
        $modeles_json = json_decode(file_get_contents(database_path('seeders/json/modeles.json')));

        // Insert Wilayas
        $data = [];
        foreach ($modeles_json as $modele) {
            $data[] = [
                'id'                => $modele->id,
                "marque_id"         =>  $modele->brand_id,
                "nom_fr"            =>  $modele->name,
                "nom_ar"            =>  $modele->name,
                "created_at"        =>  now(),
                "updated_at"        =>  now()
            ];
        }
        DB::table('modeles')->insert($data);
    }
}
