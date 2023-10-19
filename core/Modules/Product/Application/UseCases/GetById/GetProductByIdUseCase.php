<?php

namespace Core\Modules\Product\Application\UseCases\GetById;

use App\Models\ProductModel;
use Core\Infra\Log\Logger;
use Core\Modules\Product\Domain\Repositories\ProductRepository;
use Exception;

final class GetProductByIdUseCase
{
    public function __construct(
        private readonly Logger            $logger,
        private readonly ProductRepository $productRepository
    )
    {
    }

    /**
     * @throws Exception
     */
    public function execute(int $id): ProductModel|null
    {
        try {
            return $this->productRepository->findById($id);
        } catch (Exception $exception) {
            $this->logger->error('Error to get product by id: ' . $exception->getMessage());
            throw $exception;
        }
    }
}
