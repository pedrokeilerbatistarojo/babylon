<?php

namespace App\Modules\Shared\Domain\Criteria;

use Illuminate\Database\Eloquent\Builder;

class RelationCriteria implements CriteriaInterface
{
    public function __construct(
        public string $relation,
        public string $field,
        public string $operator,
        public $value
    ) {}

    /**
     * Apply criteria Builder
     */
    public function apply(Builder $builder): Builder
    {
        return $builder->whereHas($this->relation, function (Builder $query) {
            $query->where($this->field, $this->operator, $this->value);
        });
    }
}
