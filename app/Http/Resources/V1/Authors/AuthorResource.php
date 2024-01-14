<?php

namespace App\Http\Resources\V1\Authors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'firstName' => $this->user->first_name,
            'lastName' => $this->user->last_name,
        ];
    }
}