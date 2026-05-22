<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'type' => $this->data['type'] ?? 'info', 
            'title' => $this->data['title'] ?? 'Notification',
            'message' => $this->data['message'] ?? '',
            'actionUrl' => $this->data['action_url'] ?? null,
            'isRead' => $this->read_at !== null,
            'date' => $this->created_at->format('d M Y, H:i'),
        ];
    }
}
