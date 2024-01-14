<?php


namespace Tests\Unit\DataProviders;

use App\Enums\Routes\V1\RouteEnum;
use App\Models\Post;
use App\Models\User;

trait PostControllerTestDataProvider
{
    public function dataForTestStore(): array
    {
        $data = $this->logInUser();
        $data['post'] = [
            'title' => 'Test title',
            'content' => 'Test contentt',
            'authors' => [
                $data['user']->author->id
            ]
        ];

        return $data;
    }

    public function dataForTestStoreErrorTitle(): array
    {
        $data = $this->logInUser();
        $data['post'] = [
            'title' => null,
            'content' => 'Test contentt',
            'authors' => [
                $data['user']->author->id
            ]
        ];

        return $data;
    }


    public function dataForTestStoreErrorContent(): array
    {
        $data = $this->logInUser();
        $data['post'] = [
            'title' => 'Test title',
            'content' => null,
            'authors' => [
                $data['user']->author->id
            ]
        ];

        return $data;
    }

    public function dataForTestStoreErrorAuthorsRequired(): array
    {
        $data = $this->logInUser();
        $data['post'] = [
            'title' => 'Test title',
            'content' => 'Test contentt',
            'authors' => []
        ];

        return $data;
    }

    private function logInUser(): array
    {
        $user = User::factory()->author()->create();

        $response = $this->post(route(RouteEnum::LOGIN->value), [
            'email' => $user->email,
            'password' => 'demodemo'
        ]);

        $token = $response->json()['access_token'];
        return ['token' => $token, 'user' => $user];
    }

    public function dataForTestStoreSlugUnique(): array
    {
        $data = $this->logInUser();

        $post = Post::factory()->create([
            'title' => 'Test title',
            'content' => 'Test contentt',
            'slug' => 'test-title'
        ]);

        $data['postCreated'] = $post;

        $data['post'] = [
            'title' => 'Test title',
            'content' => 'Test contentt',
            'authors' => [
                $data['user']->author->id
            ]
        ];

        return $data;
    }
}
