<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return Product::with('category')->get()->map(function ($product) {
            return [
                $product->name,
                $product->barcode,
                $product->price,
                $product->category?->name,
            ];
        });
    }

    public function headings(): array
    {
        return ['Название товара', 'Штрихкод', 'Цена', 'Название категории'];
    }
}
