<?php

namespace Database\Factories;

use App\Models\Shoppinglist;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShoppinglistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Shoppinglist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->realText(12),
            'note' => Str::random(10),
        ];
    }
}
