<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = public_path('sql/categories.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
        $path = public_path('sql/subcategories.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
        $path = public_path('sql/subcategory2s.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}
