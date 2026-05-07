<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'totalCost' => (float) $this->total_cost,
            'status' => $this->status,
            'date' => $this->created_at->format('d M Y, H:i'),
            'paymentMethod' => $this->payment_method,
            'deliveryMethod' => $this->delivery_method,
            'items' => OrderItemResource::collection($this->orderItems),
        ];
    }
}
