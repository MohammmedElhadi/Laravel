<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Marque;
use App\Models\Subcategory;
use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create([
            'nom_fr' => 'Lourd',
            'nom_ar'=> 'الوزن الثقيل'
        ]);
        Type::create([
           'nom_fr' => 'Leger',
           'nom_ar'=> 'الوزن الخفيف'
        ]);
        Type::create([
            'nom_fr' => 'Moto',
            'nom_ar'=> 'الدراجات النارية'
        ]);
        Type::create([
            'nom_fr' => 'Transport',
            'nom_ar'=> 'الحـافلات'
        ]);
        Type::create([
            'nom_fr' => 'Travaux',
            'nom_ar'=> 'الحـافلات'
        ]);
        Type::create([
            'nom_fr' => 'ُMatériel agricole',
            'nom_ar'=> 'العتاد الفلاحي'
        ]);
        // Category::factory(10)->create();
        // Subcategory::factory(100)->create();
        // Marque::factory(10)->create();
    }
}
