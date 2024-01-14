<?php

namespace App\Http\Controllers\V1;

use App\Enums\Http\StatusCodeEnum;
use App\Filters\PostSearchFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Post\PostRequest;
use App\Http\Requests\V1\Post\UpdateRequest;
use App\Http\Resources\V1\ErrorResource;
use App\Http\Resources\V1\Posts\IndexResoruce;
use App\Http\Resources\V1\Posts\ShowResource;
use App\Http\Resources\V1\Posts\StoreResource;
use App\Http\Resources\V1\Posts\UpdateResource;
use App\Models\Post;
use App\Models\User;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\PostService;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    protected User|null $user;

    public function __construct(
        private PostService             $postService,
        private PostRepositoryInterface $postRepository
    )
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filter = new PostSearchFilter();
        $filter->loadParameters();

        $posts = $this->postRepository->table($filter);
        return (new IndexResoruce($posts))->response()->setStatusCode(StatusCodeEnum::OK->value);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        if ($this->user->cannot('create', Post::class)) {
            return (new ErrorResource(
                [
                    'message' => __('messages.api.auth.unauthorized_request')
                ]
            ))->response()
                ->setStatusCode(StatusCodeEnum::UNAUTHORIZED->value);
        }

        $post = $this->postService->store($request, $this->user);

        return $post ?
            (new StoreResource($post))->response()->setStatusCode(StatusCodeEnum::CREATED->value) : (new ErrorResource([]))->response()->setStatusCode(StatusCodeEnum::SERVER_ERROR->value);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return (new ShowResource($post))->response()->setStatusCode(StatusCodeEnum::OK->value);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Post $post)
    {
        if (!Gate::allows('update', $post, $this->user)) {
            return (new ErrorResource(
                [
                    'message' => __('messages.api.auth.unauthorized_request')
                ]
            ))->response()->setStatusCode(StatusCodeEnum::UNAUTHORIZED->value);
        }

        $post = $this->postService->update($request, $post, $this->user);

        return $post ?
            (new UpdateResource($post))->response()->setStatusCode(StatusCodeEnum::ACCEPTED->value) : (new ErrorResource([]))->response()->setStatusCode(StatusCodeEnum::SERVER_ERROR->value);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $id)
    {
        //
    }
}
