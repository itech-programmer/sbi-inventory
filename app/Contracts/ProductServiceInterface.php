<?php

namespace App\Contracts;

use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductServiceInterface
{
    public function getAll(): Collection;

    public function exportToExcel(): void;

    public function getById(int $id): ?Product;

    public function store(array $data): Product;

    public function update(Product $product, array $data): Product;

    public function destroy(Product $product): bool;
}