<?php

namespace App\Http\Resources\Forum\Section;

use App\Http\Resources\Forum\Branch\BranchResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionWithBranchesResource extends JsonResource
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
            'title' => $this->title,
            'branches' => BranchResource::collection($this->parentBranches)->resolve(),
        ];
    }
}
