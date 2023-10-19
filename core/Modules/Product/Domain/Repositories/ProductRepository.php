<?php

namespace Core\Modules\Product\Domain\Repositories;

use App\Models\ProductModel;
use Illuminate\Support\Collection;

interface ProductRepository
{
    /**
     * @param string $name
     * @param float $price
     * @param string $photo
     * @return ProductModel
     */
    public function create(string $name, float $price, string $photo): ProductModel;

    /**
     * @return Collection<ProductModel>
     */
    public function list(): Collection;


    /**
     * @param int $id
     * @return ProductModel|null
     */
    public function findById(int $id): ProductModel|null;

    /**
     * @param int $id
     * @param string $name
     * @param float $price
     * @param string $photo
     * @return ProductModel
     */
    public function updateById(int $id, string $name, float $price, string $photo): ProductModel;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;
}
