<?php

namespace Database\Factories\Products;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Products\Product;

use Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sku' => strtoupper(Str::random(10)),
            'name' => $this->faker->name,
            'description' => $this->faker->text($maxNbChars = rand(40, 55)),
            'quantity' => rand(0, 10),
            'price' => 500.25,
        ];
    }
}
