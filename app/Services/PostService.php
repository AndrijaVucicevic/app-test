<?php


namespace App\Services;

use App\Enums\AuditLogTypeEnum;
use App\Http\Requests\V1\Post\PostRequest;
use App\Http\Requests\V1\Post\UpdateRequest;
use App\Log\LogPost;
use App\Models\Post;
use App\Models\PostAuthor;
use App\Models\User;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\Interfaces\PostServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class PostService implements PostServiceInterface
{
    private SlugService $slugService;

    public function __construct(
        private PostRepositoryInterface $postRepository,
    )
    {
        $this->slugService = (new SlugService(new Post()));
    }

    public function store(PostRequest $request, User $user): Post|null
    {
        try {
            $data = $request->only('title', 'content');
            $data['slug'] = $this->slugService->generateSlug($data['title']);
            $authors = $request->input('authors');
            $post = null;

            DB::transaction(function () use (&$post, $data, $authors, $user) {
                $post = $this->postRepository->create($data);
                $this->addAuthors($authors, $post);

                $message = sprintf("Admin %s je kreirao post", $user->getFullNameLabel());
                $this->createAuditLog($user, [], $post->toArray(), AuditLogTypeEnum::POST_CREATE->value, $message, $post);
            });
            return $post;
        } catch (Exception $e) {
            dd($e->getMessage());
            LogPost::error(sprintf("PostService | store: %s", $e->getMessage()));
            return null;
        }
    }

    public function update(UpdateRequest $request, Post $post, User $user): Post|null
    {
        try {
            $data = $request->only('title', 'content');
            $data['slug'] = $this->slugService->updateSlug($data['title'], $post->id);
            $authors = $request->input('authors');

            DB::transaction(function () use (&$post, $data, $authors, $user) {

                $before = $post->toArray();

                $post->title = $data['title'];
                $post->content = $data['content'];
                $post->slug = $data['slug'];
                $post->save();

                $after = $post->toArray();

                $this->updateAuthors($authors, $post);

                $message = sprintf("Admin %s je izmenio post", $user->getFullNameLabel());
                $this->createAuditLog($user, $before, $after, AuditLogTypeEnum::POST_UPDATE->value, $message, $post);
            });
            return $post;
        } catch (Exception $e) {
            LogPost::error(sprintf("PostService | update: %s", $e->getMessage()));
            return null;
        }
    }

    private function addAuthors(array $authors, Post $post): void
    {
        foreach ($authors as $author) {
            PostAuthor::create([
                'author_id' => $author,
                'post_id' => $post->id
            ]);
        }
    }

    private function updateAuthors(array $authorsRequest, Post $post)
    {
        $old = $post->authors->pluck('id')->toArray();
        $removeAuthors = array_diff($old, $authorsRequest);
        $newAuthors = array_diff($authorsRequest, $old);

        PostAuthor::where('post_id', $post->id)
            ->whereIn('author_id', $removeAuthors)
            ->delete();

        $this->addAuthors($newAuthors, $post);
    }

    private function createAuditLog(
        User   $user,
        array  $before,
        array  $after,
        string $type,
        string $message,
        Post   $post
    )
    {
        audit()->log(
            type: $type,
            message: $message,
            owner: $user->id,
            meta: compact('before', 'after'),
            postId: $post->id
        );
    }
}
