<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostAuthor;
use App\Models\User;
use App\Services\SlugService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->text(100);
        return [
            'title' => $title,
            'content' => $this->faker->text(200),
            'slug' => (new SlugService(new Post()))->generateSlug($title)
        ];
    }

    public function postWithAuthor()
    {
        return $this->state(function (array $attributes) {
        })->afterCreating(function (Post $post) {
            $user = User::factory()->author();

            PostAuthor::create([
                'post_id' => $post->id,
                'author_id' => $user->author->id
            ]);
        });
    }
}
