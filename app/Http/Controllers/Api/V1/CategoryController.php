<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Category\CategoryServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(protected CategoryServiceInterface $categoryService) {}

    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAll();
        return response()->json(CategoryResource::collection($categories));
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->store($request->validated());
        return response()->json(new CategoryResource($category), 201);
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json(new CategoryResource($category));
    }

    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $updated = $this->categoryService->update($category, $request->validated());
        return response()->json(new CategoryResource($updated));
    }

    public function destroy(Category $category): JsonResponse
    {
        $this->categoryService->destroy($category);
        return response()->json(null, 204);
    }
}