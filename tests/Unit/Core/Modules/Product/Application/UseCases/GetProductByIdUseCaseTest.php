<?php

namespace Tests\Unit\Core\Modules\Product\Application\UseCases;


use App\Models\ProductModel;
use Core\Infra\Log\Logger;
use Core\Modules\Product\Application\UseCases\GetById\GetProductByIdUseCase;
use Core\Modules\Product\Domain\Repositories\ProductRepository;
use PHPUnit\Framework\TestCase;

class GetProductByIdUseCaseTest extends TestCase
{
    public function testShouldGetProductById()
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
        $useCase = new GetProductByIdUseCase($mockedLogger, $mockedProductRepository);
        $result = $useCase->execute(1);
        $this->assertNotNull($result);
        $this->assertInstanceOf(ProductModel::class, $result);
        $this->assertEquals($productProps['name'], $result->name);
        $this->assertEquals($productProps['price'], $result->price);
        $this->assertEquals($productProps['photo'], $result->photo);
    }

    protected function mockProductRepository(ProductModel $product): ProductRepository
    {
        $productRepository = $this->getMockBuilder(ProductRepository::class)->getMock();
        $productRepository->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn($product);
        return $productRepository;
    }
}
