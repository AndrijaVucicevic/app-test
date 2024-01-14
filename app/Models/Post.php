<?php

namespace App\Models;

use App\Traits\DateTimeLabelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory, DateTimeLabelTrait;

    protected $fillable = [
        'title',
        'slug',
        'content',
    ];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'post_authors');
    }

}
