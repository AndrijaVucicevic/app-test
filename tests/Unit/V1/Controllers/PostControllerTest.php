<?php

namespace Tests\Unit\V1\Controllers;

use App\Http\Resources\V1\Posts\StoreResource;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\Unit\DataProviders\PostControllerTestDataProvider;
use Illuminate\Support\Str;

class PostControllerTest extends TestCase
{
    use DatabaseTransactions, PostControllerTestDataProvider;

    protected bool $refreshDatabase = true;

    public function test_store()
    {
        $data = $this->dataForTestStore();

        $response = $this->post(
            '/api/v1/posts',
            $data['post'],
            [
                'Accept' => 'application/json',
                'Authorization' => sprintf("Bearer 4|%s", $data['token'])
            ]
        );

        $response->assertStatus(201);
        $post = $response->json()['data']['post'];

        $this->assertEquals($data['post']['title'], $post['title']);
        $this->assertEquals($data['post']['content'], $post['content']);
        $this->assertEquals(Str::slug($data['post']['title']), $post['slug']);

        $authors = $post['authors'];
        $this->assertCount(1, $authors);
        $this->assertEquals($data['user']->first_name, $authors[0]['firstName']);
        $this->assertEquals($data['user']->last_name, $authors[0]['lastName']);
    }

    public function test_store_error_title()
    {
        $data = $this->dataForTestStoreErrorTitle();

        $response = $this->post(
            '/api/v1/posts',
            $data['post'],
            [
                'Accept' => 'application/json',
                'Authorization' => sprintf("Bearer 4|%s", $data['token'])
            ]
        );

        $response->assertStatus(422)
            ->assertJson([
                "message" => str_replace(':attribute', 'title', __('validation.required')),
                "errors" => [
                    "title" => [str_replace(':attribute', 'title', __('validation.required'))],
                ]
            ]);
    }

    public function test_store_error_content()
    {
        $data = $this->dataForTestStoreErrorContent();

        $response = $this->post(
            '/api/v1/posts',
            $data['post'],
            [
                'Accept' => 'application/json',
                'Authorization' => sprintf("Bearer 4|%s", $data['token'])
            ]
        );

        $response->assertStatus(422)
            ->assertJson([
                "message" => str_replace(':attribute', 'content', __('validation.required')),
                "errors" => [
                    "content" => [str_replace(':attribute', 'content', __('validation.required'))],
                ]
            ]);
    }

    public function test_store_error_authors_required()
    {
        $data = $this->dataForTestStoreErrorAuthorsRequired();

        $response = $this->post(
            '/api/v1/posts',
            $data['post'],
            [
                'Accept' => 'application/json',
                'Authorization' => sprintf("Bearer 4|%s", $data['token'])
            ]
        );

        $response->assertStatus(422)
            ->assertJson([
                "message" => str_replace(':attribute', 'authors', __('validation.required')),
                "errors" => [
                    "authors" => [str_replace(':attribute', 'authors', __('validation.required'))],
                ]
            ]);
    }

    public function test_store_slug_unique()
    {
        $data = $this->dataForTestStoreSlugUnique();

        $response = $this->post(
            '/api/v1/posts',
            $data['post'],
            [
                'Accept' => 'application/json',
                'Authorization' => sprintf("Bearer 4|%s", $data['token'])
            ]
        );

        $response->assertStatus(201);
        $post = $response->json()['data']['post'];

        $slug = Str::slug($data['post']['title']) . '-1';
        $this->assertEquals($data['post']['title'], $post['title']);
        $this->assertEquals($data['post']['content'], $post['content']);
        $this->assertEquals($slug, $post['slug']);
    }
}
