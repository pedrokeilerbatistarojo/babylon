<?php

namespace App\Modules\Shared\Contracts;

interface UsecaseInterface
{
    public function setPayload(mixed $payload): void;
}
