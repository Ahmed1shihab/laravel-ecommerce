<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'details' => $this->faker->text(),
            'description' => $this->faker->text(),
            'price' => $this->faker->biasedNumberBetween(100000, 1000000),
            'featured' => true,
            'quantity' => $this->faker->randomNumber(),
            'image' => '//'
        ];
    }
}
