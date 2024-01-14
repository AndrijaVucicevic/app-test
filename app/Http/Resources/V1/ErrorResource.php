<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
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
            'message' => $this['message'] ?? __('messages.errors_general'),
            'errors' => $this['errors'] ?? []
        ];
    }
}
