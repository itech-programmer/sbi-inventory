<?php

namespace app\Http\Controllers\Api\V1;

use App\Contracts\Product\ProductServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(
        protected ProductServiceInterface $service
    ) {}

    public function index(): JsonResponse
    {
        return response()->json(ProductResource::collection($this->service->getAll()));
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->service->store($request->validated());
        return response()->json(new ProductResource($product), 201);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json(new ProductResource($product->load('category')));
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $updated = $this->service->update($product, $request->validated());
        return response()->json(new ProductResource($updated));
    }

    public function destroy(Product $product): JsonResponse
    {
        $this->service->destroy($product);
        return response()->json(null, 204);
    }
}