<?php

namespace Tests\Unit\Core\Modules\Product\Application\UseCases\List;

use App\Models\ProductModel;
use Core\Infra\Log\Logger;
use Core\Modules\Product\Application\UseCases\List\ListProductsUseCase;
use Core\Modules\Product\Domain\Repositories\ProductRepository;
use Exception;
use Illuminate\Support\Collection;
use PHPUnit\Framework\MockObject\Exception as PHPUnitException;
use PHPUnit\Framework\TestCase;

class ListProductsUseCaseTest extends TestCase
{
    /**
     * @throws Exception
     * @throws PHPUnitException
     */
    public function testShouldReturnsAnEmptyListProducts()
    {
        $mockedLogger = $this->createMock(Logger::class);
        $mockedLogger->expects($this->never())
            ->method('error');
        $mockedProductRepository = $this->mockProductRepository(collect());
        $useCase = new ListProductsUseCase($mockedLogger, $mockedProductRepository);
        $result = $useCase->execute();
        $this->assertEmpty($result);
    }

    /**
     * @throws PHPUnitException
     * @throws Exception
     */
    public function testShouldReturnsAListProducts()
    {
        $mockedLogger = $this->createMock(Logger::class);
        $mockedLogger->expects($this->never())
            ->method('error');
        $mockedProductCollection = collect([
            new ProductModel(['foo', 2.34, 'https://fakeimg.pl/300/']),
            new ProductModel(['bar', 2.35, 'https://fakeimg.pl/400/']),
        ]);
        $mockedProductRepository = $this->mockProductRepository($mockedProductCollection);
        $useCase = new ListProductsUseCase($mockedLogger, $mockedProductRepository);
        $result = $useCase->execute();
        $this->assertNotEmpty($result);
        $this->assertCount($mockedProductCollection->count(), $result);
    }

    protected function mockProductRepository(Collection $products): ProductRepository
    {
        $productRepository = $this->getMockBuilder(ProductRepository::class)->getMock();
        $productRepository->expects($this->any())
            ->method('list')
            ->willReturn($products);
        return $productRepository;
    }
}
