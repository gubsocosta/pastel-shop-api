<?php

namespace Tests\Unit\Core\Modules\Product\Application\UseCases\Create;

use Core\Infra\Log\Logger;
use Core\Modules\Product\Application\UseCases\Create\CreateProductInput;
use Core\Modules\Product\Application\UseCases\Create\CreateProductUseCase;
use Core\Modules\Product\Domain\Exceptions\ProductNameHasAlreadyBeenUsedException;
use Core\Modules\Product\Infra\Repositories\MemoryProductRepository;
use Exception;
use PHPUnit\Framework\MockObject\Exception as PHPUnitException;
use PHPUnit\Framework\TestCase;

class CreateProductUseCaseTest extends TestCase
{
    /**
     * @throws PHPUnitException
     * @throws Exception
     */
    public function testShouldCreateAProduct()
    {
        $mockedLogger = $this->createMock(Logger::class);
        $mockedLogger->expects($this->never())
            ->method('error');
        $productRepository = new MemoryProductRepository();
        $useCase = new CreateProductUseCase($mockedLogger, $productRepository);
        $useCase->execute(new CreateProductInput('foo', 2.34, 'https://fakeimg.pl/300/'));
        $foundProduct = $productRepository->findByName('foo');
        $this->assertNotNull($foundProduct);
        $this->assertEquals('foo', $foundProduct->name);
        $this->assertEquals(2.34, $foundProduct->price);
        $this->assertEquals('https://fakeimg.pl/300/', $foundProduct->photo);
    }

    /**
     * @throws PHPUnitException
     * @throws Exception
     */
    public function testShouldThrowAnExceptionWhenCreatingAnExistingProduct()
    {
        $productName = 'foo';
        $mockedLogger = $this->createMock(Logger::class);
        $mockedLogger->expects($this->once())
            ->method('error')
            ->with("Error to create a product: the product name '$productName' has already been used");
        $productRepository = new MemoryProductRepository();
        $productRepository->create($productName, 2.34, 'https://fakeimg.pl/300/');
        $useCase = new CreateProductUseCase($mockedLogger, $productRepository);
        $this->expectException(ProductNameHasAlreadyBeenUsedException::class);
        $useCase->execute(new CreateProductInput('foo', 2.34, 'https://fakeimg.pl/300/'));
    }
}
