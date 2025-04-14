<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2'],
            'price' => ['required', 'numeric', 'min:0'],
            'barcode' => ['required', 'string', 'regex:/^\d{13}$/', 'unique:products,barcode'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'barcode.regex' => 'Штрихкод должен соответствовать формату EAN-13 (13 цифр)',
        ];
    }
}
