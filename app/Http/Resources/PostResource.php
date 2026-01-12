<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'published_at' => optional($this->published_at)->toIso8601String(),
            'author' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
        ];
    }
}
