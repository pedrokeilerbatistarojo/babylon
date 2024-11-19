<?php

namespace App\Modules\Users\Domain\Resources;

use App\Modules\Shared\Contracts\FactoryResourceInterface;
use App\Modules\Shared\Domain\Dtos\SearchRequest;
use App\Modules\Shared\Domain\Resources\BaseAttributesResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FactoryUserResource implements FactoryResourceInterface
{
    public static function create(LengthAwarePaginator $data, SearchRequest $searchRequest): BaseAttributesResource|UserResource
    {
        if (! empty($searchRequest->includes)) {
            return new UserResource($data);
        } elseif (empty($searchRequest->columns)) {
            return new UserResource($data);
        }

        return new BaseAttributesResource($data);
    }
}
