<?php

namespace App\Modules\Shared\Domain\Criteria;

interface CriteriaFactoryInterface
{
    public function create($key, $operator, $value, $operationType);
}
