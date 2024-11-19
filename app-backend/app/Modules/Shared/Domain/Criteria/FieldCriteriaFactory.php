<?php

namespace App\Modules\Shared\Domain\Criteria;

use App\Shared\Domain\Enums\OperationTypeEnum;
use InvalidArgumentException;

class FieldCriteriaFactory implements CriteriaFactoryInterface
{
    public function create($key, $operator, $value, $operationType = OperationTypeEnum::AND)
    {
        if (empty($operationType)) {
            $operationType = OperationTypeEnum::AND;
        }

        $criteriaClass = $this->resolveCriteriaClass($operationType->value);

        if (strtolower($operator) == 'like') {
            $value = "%$value%";
        }

        return new $criteriaClass($key, $operator, $value);
    }

    protected function resolveCriteriaClass(string $operation): string
    {
        return match (strtolower($operation)) {
            'and' => FieldCriteria::class,
            'or' => FieldCriteriaOr::class,
            default => throw new InvalidArgumentException("Operation not admitted: $operation"),
        };
    }
}
