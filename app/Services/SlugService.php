<?php


namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SlugService
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function generateSlug(string $title): string
    {
        $title = trim($title);
        $slug = Str::slug($title);

        $count = $this->model->where('title', $title)->count();
        if ($count == 0) {
            return $slug;
        } else {
            return sprintf('%s-%s', $slug, $count);
        }
    }

    public function updateSlug(string $title, int $id): string
    {
        $title = trim($title);
        $slug = Str::slug($title);
        $post = $this->model->where('title', $title)
            ->where('id', $id)->first();

        if ($post) {
            return $post->slug;
        }

        $count = $this->model->where('title', $title)
            ->where('id', '<>', $id)
            ->count();
        if ($count == 0) {
            return $slug;
        } else {
            return sprintf('%s-%s', $slug, $count);
        }
    }
}
