<?php

namespace App\Services\Interfaces;


interface AuditServiceInterface
{

    public function log(
        string   $type,
        string   $message,
        array    $meta = [],
        int|null $owner = null,
        int|null $postId
    ): void;

}