<?php

namespace App\Http\Resources\Forum\Complaint;

use App\Http\Resources\Chat\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
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
            'message_id' => $this->message_id,
            'page' => $this->page,
            'user' => UserResource::make($this->user)->resolve(),
            'theme_id' => $this->theme_id,
            'body' => $this->body,
            'is_solved' => $this->is_solved,
        ];
    }
}
