<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\ProductModel;
use Core\Modules\Product\Application\UseCases\Create\CreateProductInput;
use Core\Modules\Product\Application\UseCases\Create\CreateProductUseCase;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct(
        private readonly CreateProductUseCase $createProductUseCase
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * @param StoreProductRequest $request
     * @return JsonResponse|ProductResource<ProductModel>
     */
    public function store(StoreProductRequest $request): JsonResponse|ProductResource
    {
        $validated = $request->validated();
        try {
            if (!$request->hasFile('photo')) {
                return response()->json("photo is required");
            }
            $photo = $request->file('photo');
            $path = $photo->store('images/products', 'public');
            $fullPathPhoto = env('APP_URL') . Storage::url($path);
            $name = $validated['name'];
            $price = $validated['price'];
            $newProduct = $this->createProductUseCase->execute(new CreateProductInput($name, $price, $fullPathPhoto));
            return new ProductResource($newProduct);
        } catch (Exception $exception) {
            Log::error('Error to process request: ' . $exception->getMessage());
            return response()->abort(500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductModel $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductModel $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductModel $product)
    {
        //
    }
}
