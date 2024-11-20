<?php

namespace App\Modules\Shared\Infrastructure\Services;

use App\Modules\Shared\Domain\Enums\OperationTypeEnum;

class OperationTypeService
{
    public static function findByValue(string $value): ?OperationTypeEnum
    {
        foreach (OperationTypeEnum::cases() as $enumValue) {
            if ($enumValue->value === $value) {
                return $enumValue;
            }
        }

        return null;
    }

    public static function findByName(string $name): ?OperationTypeEnum
    {
        foreach (OperationTypeEnum::cases() as $enumValue) {
            if ($enumValue->name === $name) {
                return $enumValue;
            }
        }

        return null;
    }
}
