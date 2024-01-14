<?php


namespace App\Services;

use App\Models\AuditLog;
use App\Services\Interfaces\AuditServiceInterface;

class AuditService implements AuditServiceInterface
{

    public function log(
        string   $type,
        string   $message,
        array    $meta = [],
        int|null $owner = null,
        int|null $postId
    ): void
    {
        AuditLog::create([
            'action_type' => $type,
            'message' => $message,
            'meta' => $meta,
            'owner' => $owner,
            'post_id' => $postId,
        ]);
    }
}
