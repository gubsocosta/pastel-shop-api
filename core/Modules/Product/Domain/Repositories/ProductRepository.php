<?php

namespace Core\Modules\Product\Domain\Repositories;

use App\Models\ProductModel;

interface ProductRepository
{
    public function create(
        string $name,
        float  $price,
        string $photo
    ): ProductModel;

    public function findByName(string $name): ProductModel|null;
}
