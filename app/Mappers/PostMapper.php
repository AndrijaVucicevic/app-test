<?php

namespace App\Mappers;

use App\Interfaces\MapperInterface;
use Request;

class PostMapper implements MapperInterface
{
    public static function mapToModelCreateAttributes(array $formData): array
    {
        return [
            'title' => $formData['title'],
            'content' => $formData['content']
        ];
    }
}
