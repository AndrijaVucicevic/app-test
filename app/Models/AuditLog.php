<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'action_type',
        'message',
        'owner',
        'post_id',
        'meta',
    ];

    protected $casts = [
        'meta' => 'json',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'owner');
    }
}
