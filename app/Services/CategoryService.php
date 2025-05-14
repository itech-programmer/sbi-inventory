<?php

namespace App\Services;

use App\Contracts\Category\CategoryRepositoryInterface;
use App\Contracts\Category\CategoryServiceInterface;
use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryService implements CategoryServiceInterface
{
    public function __construct(protected CategoryRepositoryInterface $repository) {}

    public function getAll(): Collection
    {
        return $this->repository->all();
    }

    public function getById(int $id): ?Category
    {
        return $this->repository->find($id);
    }

    public function store(array $data): Category
    {
        return $this->repository->create($data);
    }

    public function update(Category $category, array $data): Category
    {
        return $this->repository->update($category, $data);
    }

    public function destroy(Category $category): bool
    {
        return $this->repository->delete($category);
    }
}
