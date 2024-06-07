<?php

namespace App\Http\Resources\Chat;

use App\Http\Resources\Message\MessageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $chatWith = count($this->chatWith) == 1 ? $this->chatWith[0]->name : count($this->chatWith) . ' users';
        return [
            'id' => $this->id,
            'title' => $this->title ?? 'Chat with ' . $chatWith,
            'users' => $this->users,
            'unreadable_message_count' => $this->unreadable_message_count,
            'last_message' => isset($this->lastMessage) ? MessageResource::make($this->lastMessage)->resolve() : null,
        ];
    }
}
