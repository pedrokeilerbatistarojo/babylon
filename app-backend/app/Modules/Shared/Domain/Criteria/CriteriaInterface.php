<?php

namespace App\Modules\Shared\Domain\Criteria;

use Illuminate\Database\Eloquent\Builder;

interface CriteriaInterface
{
    /**
     * Apply criteria Builder
     */
    public function apply(Builder $builder): Builder;
}
