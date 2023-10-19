<?php

namespace Core\Modules\Product\Infra\Repositories;

use App\Models\ProductModel;
use Core\Modules\Product\Domain\Repositories\ProductRepository;
use Core\Modules\Shared\Domain\Exceptions\EntityNotFoundException;
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

    public function list(): Collection
    {
        return ProductModel::all();
    }

    public function updateById(int $id, string $name, float $price, string $photo): ProductModel
    {
        $foundProduct = $this->findById($id);
        if (!$foundProduct) {
            throw new EntityNotFoundException('product');
        }
        $foundProduct->update([
            'name' => $name,
            'price' => $price,
            'photo' => $photo
        ]);
        return $foundProduct;
    }

    public function findById(int $id): ProductModel|null
    {
        return ProductModel::find($id);
    }

    public function delete(int $id): void
    {
        ProductModel::destroy($id);
    }
}
