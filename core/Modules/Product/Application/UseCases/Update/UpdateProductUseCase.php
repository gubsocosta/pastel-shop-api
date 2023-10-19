<?php

namespace Core\Modules\Product\Application\UseCases\Update;

use App\Models\ProductModel;
use Core\Infra\Log\Logger;
use Core\Modules\Product\Domain\Repositories\ProductRepository;
use Exception;

final class UpdateProductUseCase
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
    public function execute(UpdateProductInput $input): ProductModel
    {
        try {
            return $this->productRepository->updateById(
                $input->id,
                $input->name,
                $input->price,
                $input->photo
            );
        } catch (Exception $exception) {
            $this->logger->error('Error to update product: ' . $exception->getMessage());
            throw $exception;
        }
    }
}
