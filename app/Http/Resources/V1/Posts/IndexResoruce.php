<?php

namespace App\Http\Resources\V1\Posts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResoruce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = 'data';

    public function toArray(Request $request): array
    {
        return [
            'posts' => PostResource::collection($this),
            'total' => $this->total(),
            'currentPage' => $this->currentPage(),
            'perPage' => $this->perPage(),
            'lastPage' => $this->lastPage(),
        ];
    }
}
