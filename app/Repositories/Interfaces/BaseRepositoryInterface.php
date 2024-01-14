<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function findById(int|string $id);

    public function findByIdWithRelations(int|string $id, string $relation);

    public function delete(int|string $id);

    public function create(array $data): Model;
}
