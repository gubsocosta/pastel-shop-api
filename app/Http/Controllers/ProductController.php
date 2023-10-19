<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\ProductModel;
use Core\Modules\Product\Application\UseCases\Create\CreateProductInput;
use Core\Modules\Product\Application\UseCases\Create\CreateProductUseCase;
use Core\Modules\Product\Application\UseCases\Delete\DeleteProductUseCase;
use Core\Modules\Product\Application\UseCases\GetById\GetProductByIdUseCase;
use Core\Modules\Product\Application\UseCases\List\ListProductsUseCase;
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

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        try {
            if (!$request->hasFile('photo')) {
                return response()->json("photo is required", 422);
            }
            $photo = $request->file('photo');
            $path = $photo->store('images/products', 'public');
            $fullPathPhoto = env('APP_URL') . Storage::url($path);
            $name = $validated['name'];
            $price = $validated['price'];
            $newProduct = $this->createProductUseCase->execute(new CreateProductInput($name, $price, $fullPathPhoto));
            return new ProductResource($newProduct);
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductModel $product)
    {
        //
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
}
