<?php

namespace Core\Modules\Product\Application\UseCases\Delete;

use Core\Infra\Log\Logger;
use Core\Modules\Product\Domain\Repositories\ProductRepository;
use Core\Modules\Shared\Domain\Exceptions\EntityNotFoundException;
use Exception;

final class DeleteProductUseCase
{
    public function __construct(
        private readonly Logger            $logger,
        private readonly ProductRepository $productRepository
    )
    {
    }

    /**
     * @throws EntityNotFoundException
     */
    public function execute(int $id): void
    {
        try {
            $foundProduct = $this->productRepository->findById($id);
            if (!$foundProduct) {
                throw new EntityNotFoundException('product');
            }
            $this->productRepository->delete($id);

        } catch (Exception $exception) {
            $this->logger->error('Error to delete product: ' . $exception->getMessage());
            throw $exception;
        }
    }

}
