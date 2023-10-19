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
    public function create(
        string $name,
        float  $price,
        string $photo
    ): ProductModel;

    /**
     * @param string $name
     * @return ProductModel|null
     */
    public function findByName(string $name): ProductModel|null;

    /**
     * @param int $id
     * @return ProductModel|null
     */
    public function findById(int $id): ProductModel|null;

    /**
     * @return Collection<ProductModel>
     */
    public function list(): Collection;

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;
}
