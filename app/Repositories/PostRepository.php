<?php


namespace App\Repositories;

use App\Filters\PostSearchFilter;
use App\Helpers\DateTimeHelper as DTH;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{

    function __construct(Post $postModel)
    {
        parent::__construct($postModel);
    }

    public function table(PostSearchFilter $filter): LengthAwarePaginator
    {
        try {
            return Post::select(DB::raw('posts.*'))
                ->where($this->searchFilter($filter))
                ->groupBy('posts.id')
                ->orderBy('posts.id', 'desc')
                ->paginate($filter->perPage, ['*'], 'page', $filter->page);
        } catch (Exception $e) {
            Log::error(sprintf("PostRepository | table: %s", $e->getMessage()));
            return new LengthAwarePaginator([], 0, $filter->perPage);
        }
    }


    private function searchFilter(PostSearchFilter $filter): callable
    {
        return function ($query) use ($filter) {

            if ($filter->dateFrom && $filter->dateTo) {
                $query->whereBetween('posts.created_at',
                    DTH::formatDatesForBetween(
                        dateFrom: $filter->dateFrom,
                        dateTo: $filter->dateTo
                    ));
            }
        };
    }
}
