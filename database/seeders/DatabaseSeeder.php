<?php

namespace Database\Seeders;

use App\Models\Piece;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CitiesSeeder::class);
        $this->call(ContinentsSeeder::class);
        $this->call(MarquesSeeder::class);
        $this->call(ModelesSeeder::class);
        User::factory(10)->create();
        $this->call(PermissionTableSeeder::class);
        $this->call(PlanSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(PieceSeeder::class);
        $this->call(EtatSeeder::class);
        $this->call(CatsSeeder::class);
        $user = User::find(12);
        $user->modeles()->attach([1 , 2 , 3 , 4]);
        $user->marques()->attach([1 , 2 , 3 , 4]);
        $user->categories()->attach([1 , 2 , 3 , 4]);
        $user->subcategories()->attach([1 , 2 , 3 , 4]);
        $user->types()->attach([1 , 3]);

        $user = User::find(2);
        $user->modeles()->attach([3,4,5,6]);
        $user->marques()->attach([3,4,5,6]);
        $user->categories()->attach([3,4,5,6]);
        $user->subcategories()->attach([3,4,5,6]);
        $user->types()->attach([3]);

        $user = User::find(3);
        $user->modeles()->attach([4,5,6,7]);
        $user->marques()->attach([4,5,6,7]);
        $user->categories()->attach([4,5,6,7]);
        $user->subcategories()->attach([4,5,6,7]);
        $user->types()->attach([2]);

    }
}
