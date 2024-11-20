<?php

namespace App\Modules\Shared\Infrastructure\Services;

use App\Modules\Shared\Domain\Criteria\CriteriaInterface;
use App\Modules\Shared\Domain\Enums\SQLSortEnum;
use Illuminate\Database\Eloquent\Builder;

class SearchRepositoryService
{
    /**
     * Perform a generic search operation on the repository.
     *
     * @param  array  $criteria  Custom search criteria.
     */
    public static function applySearchParams(
        Builder $query,
        array $criteria,
        array $columns,
        array $includes,
        string $sortField,
        SQLSortEnum $sortType,
        array $joins = [],
    ): Builder {

        $query->select($columns);

        foreach ($criteria as $criterion) {
            if ($criterion instanceof CriteriaInterface) {
                $criterion->apply($query);
            }
        }

        if (count($joins)) {
            foreach ($joins as $join) {

                /*
                if (! is_array($join) && count($joins) !== 4) {
                    continue;
                }
                $query->join($join[0], $join[1], $join[2], $join[3]);
                */

                if (! is_array($join)) {
                    continue;
                }

                $c = count($join);
                if ($c < 4) {
                    continue;
                } elseif ($c === 5) {
                    //$table, $first, $operator = null, $second = null, $type = 'inner', $where = false
                    $query->join($join[0], $join[1], $join[2], $join[3], $join[4]);
                } else {
                    $query->join($join[0], $join[1], $join[2], $join[3]);
                }

            }
        }

        $query->with($includes);
        $query->orderBy($sortField, $sortType->value);

        return $query;
    }
}
