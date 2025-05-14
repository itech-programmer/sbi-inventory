<?php

namespace App\Contracts\Category;

use App\Models\Category;
use Illuminate\Support\Collection;

interface CategoryServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Category;
    public function store(array $data): Category;
    public function update(Category $category, array $data): Category;
    public function destroy(Category $category): bool;
}