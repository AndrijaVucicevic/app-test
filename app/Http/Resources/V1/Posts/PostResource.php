<?php

namespace App\Http\Resources\V1\Posts;

use App\Http\Resources\V1\Authors\AuthorResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = '';

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'authors' => AuthorResource::collection($this->authors),
            'createdAt' => $this->getCreatedAtDateTimeLabel(),
            'updatedAt' => $this->getUpdatedAtDateTimeLabel()
        ];
    }
}
