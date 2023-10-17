<?php

namespace Database\Factories;

use App\Models\BaseModel;
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
        $name = $this->faker->name();
        $price = $this->faker->randomFloat(2);
        $photo = $this->faker->imageUrl();
        return [
            'name' => $name,
            'price' => $price,
            'photo' => $photo
        ];
    }
}
