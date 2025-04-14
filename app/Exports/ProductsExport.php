<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection()
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
