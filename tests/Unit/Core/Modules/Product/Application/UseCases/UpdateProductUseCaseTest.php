<?php

namespace Tests\Unit\Core\Modules\Product\Application\UseCases;

use App\Models\ProductModel;
use Core\Infra\Log\Logger;
use Core\Modules\Product\Application\UseCases\Update\UpdateProductInput;
use Core\Modules\Product\Application\UseCases\Update\UpdateProductUseCase;
use Core\Modules\Product\Domain\Repositories\ProductRepository;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class UpdateProductUseCaseTest extends TestCase
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function testShouldUpdateAProduct()
    {
        $productProps = [
            'id' => 1,
            'name' => 'bar',
            'price' => 2.35,
            'photo' => 'https://fakeimg.pl/400/'
        ];
        $mockedLogger = $this->createMock(Logger::class);
        $mockedLogger->expects($this->never())
            ->method('error');
        $mockedProductRepository = $this->mockProductRepository(new ProductModel($productProps));
        $useCase = new UpdateProductUseCase($mockedLogger, $mockedProductRepository);
        $result = $useCase->execute(new UpdateProductInput(
            (int)$productProps['id'],
            $productProps['name'],
            (float)$productProps['price'],
            $productProps['photo'],
        ));
        $this->assertInstanceOf(ProductModel::class, $result);
        $this->assertEquals($productProps['name'], $result->name);
        $this->assertEquals($productProps['price'], $result->price);
        $this->assertEquals($productProps['photo'], $result->photo);
    }

    protected function mockProductRepository(ProductModel $product): ProductRepository
    {
        $productRepository = $this->getMockBuilder(ProductRepository::class)->getMock();
        $productRepository->expects($this->once())
            ->method('updateById')
            ->with(1)
            ->willReturn($product);
        return $productRepository;
    }
}
