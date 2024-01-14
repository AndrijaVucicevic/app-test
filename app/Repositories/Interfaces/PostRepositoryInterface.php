<?php

namespace App\Repositories\Interfaces;

use App\Filters\PostSearchFilter;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface extends BaseRepositoryInterface
{

    public function table(PostSearchFilter $filter): LengthAwarePaginator;
}
