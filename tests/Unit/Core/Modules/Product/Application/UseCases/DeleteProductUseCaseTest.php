<?php

namespace Tests\Unit\Core\Modules\Product\Application\UseCases;

use App\Models\ProductModel;
use Core\Infra\Log\Logger;
use Core\Modules\Product\Application\UseCases\Delete\DeleteProductUseCase;
use Core\Modules\Product\Domain\Repositories\ProductRepository;
use Core\Modules\Shared\Domain\Exceptions\EntityNotFoundException;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class DeleteProductUseCaseTest extends TestCase
{

    /**
     * @throws Exception
     * @throws EntityNotFoundException
     */
    public function testShouldDeleteAProductById()
    {
        $productProps = [
            'id' => 1,
            'name' => 'foo',
            'price' => 2.34,
            'photo' => 'https://fakeimg.pl/300/'
        ];
        $mockedLogger = $this->createMock(Logger::class);
        $mockedLogger->expects($this->never())
            ->method('error');
        $mockedProductRepository = $this->mockProductRepository(new ProductModel($productProps));
        $useCase = new DeleteProductUseCase($mockedLogger, $mockedProductRepository);
        $this->assertNull($useCase->execute($productProps['id']));
    }

    protected function mockProductRepository(ProductModel $product): ProductRepository
    {
        $productRepository = $this->getMockBuilder(ProductRepository::class)->getMock();
        $productRepository->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn($product);
        $productRepository->expects($this->once())
            ->method('delete')
            ->with(1);
        return $productRepository;
    }
}
