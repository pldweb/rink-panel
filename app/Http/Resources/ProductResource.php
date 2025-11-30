<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'store' => new StoreResource($this->store),
            'product_category_id' => new ProductCategoryResource($this->product_category),
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'condition' => $this->condition,
            'price' => (float) (string) $this->price,
            'weight' => $this->weight,
            'stock' => $this->stock,
            'product_images' => ProductImageResource::collection($this->whenLoaded('productImages'))
        ];
    }
}
