<?php

namespace App\Modules\Shared\Domain\Criteria;

use Illuminate\Database\Eloquent\Builder;

class FieldCriteria implements CriteriaInterface
{
    public function __construct(
        public string $field,
        public string $operator,
        public $value
    ) {}

    /**
     * Apply criteria Builder
     */
    public function apply(Builder $builder): Builder
    {
        //Todo: move to better place
        if (strtolower($this->operator) === 'in') {
            return $builder->whereIn($this->field, $this->value);
        }

        return $builder->where($this->field, $this->operator, $this->value);
    }
}
