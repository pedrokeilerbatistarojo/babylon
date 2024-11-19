<?php

namespace App\Modules\Shared\Domain\Dtos;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginateResponse
{
    public ResourceCollection|array $items;

    public array $paginationData;

    public array $totals;
}
