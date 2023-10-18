<?php

namespace Core\Modules\Product\Application\UseCases\Create;

use App\Models\ProductModel;
use Core\Infra\Log\Logger;
use Core\Modules\Product\Domain\Repositories\ProductRepository;
use Exception;

final class CreateProductUseCase
{
    public function __construct(
        private readonly Logger            $logger,
        private readonly ProductRepository $productRepository,
    )
    {
    }

    /**
     * @param CreateProductInput $input
     * @return ProductModel
     * @throws Exception
     */
    public function execute(CreateProductInput $input): ProductModel
    {
        try {
            return $this->productRepository->create($input->name, $input->price, $input->photo);
        } catch (Exception $exception) {
            $this->logger->error('Error to create a product: ' . $exception->getMessage());
            throw $exception;
        }
    }
}
