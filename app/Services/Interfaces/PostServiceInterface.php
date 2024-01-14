<?php


namespace App\Services\Interfaces;

use App\Http\Requests\V1\Post\PostRequest;
use App\Http\Requests\V1\Post\UpdateRequest;
use App\Models\Post;
use App\Models\User;

interface PostServiceInterface
{
    public function store(PostRequest $request, User $user): Post|null;

    public function update(UpdateRequest $request, Post $post, User $user): Post|null;
}
