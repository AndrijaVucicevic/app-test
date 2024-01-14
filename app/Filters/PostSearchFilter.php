<?php


namespace App\Filters;

use App\Interfaces\SearchFilterInterface;

class PostSearchFilter implements SearchFilterInterface
{
    public string $dateFrom;
    public string $dateTo;
    public int $perPage;
    public int $page;

    public function loadParameters(): void
    {
        $this->dateFrom = request('filter_date_from', '');
        $this->dateTo = request('filter_date_to', '');
        $this->perPage = request('per_page', 5);
        $this->page = request('page', 1);
    }
}
