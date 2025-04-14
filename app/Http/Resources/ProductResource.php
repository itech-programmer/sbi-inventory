<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'barcode' => $this->barcode,
            'category' => $this->whenLoaded('category', function () {
                return $this->category->name;
            }),
        ];
    }
}