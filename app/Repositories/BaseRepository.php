<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model = null)
    {
        $this->model = $model;
    }

    public function findById(int|string $id)
    {
        try {
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    public function findByIdWithRelations(int|string $id, string $relation)
    {
        return $this->model->with($relation)->findOrFail($id);
    }

    public function delete(int|string $id)
    {
        $model = $this->model->findOrFail($id);
        return $model->delete();
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }
}
