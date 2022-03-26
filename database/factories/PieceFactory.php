<?php

namespace Database\Factories;

use App\Models\Piece;
use Illuminate\Database\Eloquent\Factories\Factory;

class PieceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Piece::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'lib' =>$this->faker->name(),
            'liba'=>$this->faker->name(),
            'ref'=>$this->faker->word(),
            'subcategory_id' => random_int(1,10),
        ];
    }
}
