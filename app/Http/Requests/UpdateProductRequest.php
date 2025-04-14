<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function rules(): array
    {
        $id = $this->route('product')->id ?? null;

        return [
            'name' => ['sometimes', 'string', 'min:2'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'barcode' => ['sometimes', 'string', 'regex:/^\d{13}$/', 'unique:products,barcode,' . $id],
            'category_id' => ['sometimes', 'exists:categories,id'],
        ];
    }
}
