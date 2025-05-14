<?php

namespace App\Repositories;
use App\Contracts\Category\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all(): Collection
    {
        return Category::all();
    }
    public function find(int $id): ?Category
    {
        return Category::findOrFail($id);
    }
    public function create(array $data) : Category
    {
        return Category::create($data);
    }
    public function update(Category $category, array $data): Category
    {
        $category->update($data);
        return $category;
    }
    public function delete(Category $category): bool
    {
        return $category->delete();
    }
}