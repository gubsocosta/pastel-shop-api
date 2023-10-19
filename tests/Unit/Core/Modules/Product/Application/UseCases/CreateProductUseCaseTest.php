<?php

namespace Tests\Unit\Core\Modules\Product\Application\UseCases;

use App\Models\ProductModel;
use Core\Infra\Log\Logger;
use Core\Modules\Product\Application\UseCases\Create\CreateProductInput;
use Core\Modules\Product\Application\UseCases\Create\CreateProductUseCase;
use Core\Modules\Product\Domain\Repositories\ProductRepository;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\MockObject\Exception as PHPUnitException;
use Tests\TestCase;

class CreateProductUseCaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws PHPUnitException
     * @throws Exception
     */
    public function testShouldCreateAProduct()
    {
        $productProps = [
            'name' => 'foo',
            'price' => 2.34,
            'photo' => 'https://fakeimg.pl/300/'
        ];
        $mockedLogger = $this->createMock(Logger::class);
        $mockedLogger->expects($this->never())
            ->method('error');
        $mockedProductRepository = $this->mockProductRepository(new ProductModel($productProps));
        $this->assertDatabaseMissing('products', $productProps);
        $useCase = new CreateProductUseCase($mockedLogger, $mockedProductRepository);
        $result = $useCase->execute(new CreateProductInput($productProps['name'], $productProps['price'], $productProps['photo']));
        $this->assertInstanceOf(ProductModel::class, $result);
        $this->assertEquals($productProps['name'], $result->name);
        $this->assertEquals($productProps['price'], $result->price);
        $this->assertEquals($productProps['photo'], $result->photo);
    }

    protected function mockProductRepository(ProductModel $product): ProductRepository
    {
        $productRepository = $this->getMockBuilder(ProductRepository::class)->getMock();
        $productRepository->expects($this->once())
            ->method('create')
            ->willReturn($product);
        return $productRepository;
    }
}
