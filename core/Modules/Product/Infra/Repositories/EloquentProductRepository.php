<?php

namespace Core\Modules\Product\Infra\Repositories;

use App\Models\ProductModel;
use Core\Modules\Product\Domain\Repositories\ProductRepository;
use Illuminate\Support\Collection;

class EloquentProductRepository implements ProductRepository
{

    public function create(string $name, float $price, string $photo): ProductModel
    {
        return ProductModel::create([
            'name' => $name,
            'price' => $price,
            'photo' => $photo
        ]);
    }

    public function findByName(string $name): ProductModel|null
    {
        $foundProducts = ProductModel::where('name', $name)->get();
        return $foundProducts->first();
    }

    public function list(): Collection
    {
        return ProductModel::all();
    }
}
