<?php

namespace Database\Factories;

use App\Models\ProductModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductModel>
 */
class ProductModelFactory extends Factory
{
    protected $model = ProductModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        $price = fake()->randomFloat(2);
        $photo = fake()->imageUrl();
        return [
            'name' => $name,
            'price' => $price,
            'photo' => $photo
        ];
    }
}
