<?php

namespace App\Http\Resources\V1\Posts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
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
            'post' => PostResource::make($this)
        ];
    }
}
