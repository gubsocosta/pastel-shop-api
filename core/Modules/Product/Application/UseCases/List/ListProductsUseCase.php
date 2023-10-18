<?php

namespace Core\Modules\Product\Application\UseCases\List;

use App\Models\ProductModel;
use Core\Infra\Log\Logger;
use Core\Modules\Product\Domain\Repositories\ProductRepository;
use Exception;
use Illuminate\Support\Collection;

final class ListProductsUseCase
{
    public function __construct(
        private readonly Logger            $logger,
        private readonly ProductRepository $productRepository
    )
    {
    }

    /**
     * @return Collection<ProductModel>
     * @throws Exception
     */
    public function execute(): Collection
    {
        try {
            return $this->productRepository->list();
        } catch (Exception $exception) {
            $this->logger->error('Error to list products: ' . $exception->getMessage());
            throw $exception;
        }
    }
}
