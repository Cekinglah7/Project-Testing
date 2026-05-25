<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'categoryId' => $this->category_id,
            'brandId' => $this->brand_id,
            'name' => $this->name,
            'unit' => $this->unit,
            'price' => (float) $this->price,
            'description' => $this->description,
            'nutritionInfo' => $this->nutrition_info,
            'rating' => round($this->reviews_avg_rating ?? 0, 1), 
            'images' => ProductImageResource::collection($this->whenLoaded('images')),
        ];
    }
}
