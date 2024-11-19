<?php

namespace App\Modules\Shared\Domain\Enums;

enum OperationTypeEnum: string
{
    case AND = 'and';
    case OR = 'or';
}
