<?php

namespace App\Modules\Shared\Contracts;

use App\Modules\Shared\Domain\Dtos\SearchRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface FactoryResourceInterface
{
    public static function create(LengthAwarePaginator $data, SearchRequest $searchRequest);
}
