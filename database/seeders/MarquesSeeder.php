<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarquesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->loadData();
        $this->command->comment("Marques loaded");
    }
    protected function loadData()
    {
        $this->insertMarques();
    }

    protected function insertMarques()
    {
        // Load wilayas from json
        $marques_json = json_decode(file_get_contents(database_path('seeders/json/marques.json')));

        // Insert Wilayas
        $data = [];
        foreach ($marques_json as $marque) {
            $data[] = [
                "id"              =>   $marque->id,
                "continent_id"    =>    null,
                "url_hash"        =>    $marque->url_hash,
                "url"             =>    $marque->url,
                "nom_ar"          =>    $marque->name,
                "nom_fr"          =>    $marque->name,
                "logo"            =>    $marque->logo,
                "deleted_at"      =>    $marque->deleted_at,
                "created_at"      =>    now(),
                "updated_at"      =>     now()
            ];
        }
        DB::table('marques')->insert($data);
    }
}
