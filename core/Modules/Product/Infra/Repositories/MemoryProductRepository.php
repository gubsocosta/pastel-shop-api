<?php

namespace Core\Modules\Product\Infra\Repositories;

use App\Models\ProductModel;
use Core\Modules\Product\Domain\Exceptions\ProductNameHasAlreadyBeenUsedException;
use Core\Modules\Product\Domain\Repositories\ProductRepository;
use Illuminate\Support\Collection;

final class MemoryProductRepository implements ProductRepository
{
    /**
     * @var Collection<ProductModel>
     */
    private Collection $products;

    public function __construct()
    {
        $this->products = collect();
    }

    /**
     * @throws ProductNameHasAlreadyBeenUsedException
     */
    public function create(string $name, float $price, string $photo): ProductModel
    {
        $foundProduct = $this->findByName($name);
        if ($foundProduct) {
            throw new ProductNameHasAlreadyBeenUsedException($name);
        }
        $id = count($this->products) + 1;
        $newProduct = new ProductModel([
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'photo' => $photo
        ]);
        $this->products->add($newProduct);
        return $newProduct;
    }

    public function findByName(string $name): ProductModel|null
    {
        return $this->products->first(function (ProductModel $product) use ($name) {
            return $product->name == $name;
        });
    }

    public function list(): Collection
    {
        return $this->products;
    }
}
