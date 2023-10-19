<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use Core\Modules\Product\Application\UseCases\Create\CreateProductInput;
use Core\Modules\Product\Application\UseCases\Create\CreateProductUseCase;
use Core\Modules\Product\Application\UseCases\Delete\DeleteProductUseCase;
use Core\Modules\Product\Application\UseCases\GetById\GetProductByIdUseCase;
use Core\Modules\Product\Application\UseCases\List\ListProductsUseCase;
use Core\Modules\Product\Application\UseCases\Update\UpdateProductUseCase;
use Core\Modules\Shared\Domain\Exceptions\EntityNotFoundException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct(
        private readonly CreateProductUseCase  $createProductUseCase,
        private readonly ListProductsUseCase   $listProductsUseCase,
        private readonly DeleteProductUseCase  $deleteProductUseCase,
        private readonly GetProductByIdUseCase $getProductByIdUseCase,
        private readonly UpdateProductUseCase  $updateProductUseCase
    )
    {
    }


    public function index()
    {
        try {
            $products = $this->listProductsUseCase->execute();
            return ProductResource::collection($products);
        } catch (Exception $exception) {
            $this->internalServerError($exception);
        }
    }

    public function show(int $id)
    {
        try {
            $foundProduct = $this->getProductByIdUseCase->execute($id);
            return new ProductResource($foundProduct);
        } catch (Exception $exception) {
            $this->internalServerError($exception);
        }
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        dd($request);
        $validated = $request->validated();
        try {
            $name = $validated['name'];
            $price = $validated['price'];
            $photo = $this->storePhoto($request);
            $updatedProduct = $this->updateProductUseCase->execute($id, $name, $price, $photo);
            return new ProductResource($updatedProduct);
        } catch (EntityNotFoundException $exception) {
            $this->notFound($exception);
        } catch (Exception $exception) {
            $this->internalServerError($exception);
        }
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        try {
            $name = $validated['name'];
            $price = $validated['price'];
            $photo = $this->storePhoto($request);
            $newProduct = $this->createProductUseCase->execute(new CreateProductInput($name, $price, $photo));
            return new ProductResource($newProduct);
        } catch (Exception $exception) {
            $this->internalServerError($exception);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->deleteProductUseCase->execute($id);
            return response()->json("", 204);
        } catch (EntityNotFoundException $exception) {
            $this->notFound($exception);
        } catch (Exception $exception) {
            $this->internalServerError($exception);
        }
    }

    private function storePhoto(Request $request): string
    {
        if (!$request->hasFile('photo')) {
            return response()->json("photo is required", 422);
        }
        $photo = $request->file('photo');
        $path = $photo->store('images/products', 'public');
        return env('APP_URL') . Storage::url($path);
    }
}
