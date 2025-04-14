<?php

namespace App\Services;

use App\Contracts\ProductRepositoryInterface;
use App\Contracts\ProductServiceInterface;
use App\Jobs\ExportProductsJob;
use App\Models\Product;
use Illuminate\Support\Collection;

class ProductService implements ProductServiceInterface
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->productRepository->all();
    }

    public function exportToExcel(): void
    {
        ExportProductsJob::dispatch();
    }

    public function getById(int $id): ?Product
    {
        return $this->productRepository->find($id);
    }

    public function store(array $data): Product
    {
        return $this->productRepository->create($data);
    }

    public function update(Product $product, array $data): Product
    {
        return $this->productRepository->update($product, $data);
    }

    public function destroy(Product $product): bool
    {
        return $this->productRepository->delete($product);
    }
}