<?php

namespace App\Http\Resources\Forum\Message;

use App\Http\Resources\Forum\User\UserForumResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageForumResource extends JsonResource
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
            'content' => $this->content,
            'theme_id' => $this->theme_id,
            'user' => UserForumResource::make($this->user)->resolve(),
            'avatar' => url('storage/' . $this->user->avatar),
            'time' => $this->created_at->format('d-m-Y'),
            'is_liked' => $this->is_liked,
            'is_solved' => !($this->isNotSolvedComplaint->count() > 0),
            'liked_users' => UserForumResource::collection($this->likedUsers)->resolve(),
        ];
    }
}
