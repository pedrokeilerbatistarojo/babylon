<?php

namespace App\Modules\Shared\Application\Usecases;

use App\Shared\Domain\Dtos\UpdateInputObject;

trait TraitHandleUpdatePayload
{
    private ?UpdateInputObject $payload = null;

    /**
     * @throws \Exception
     */
    public function setPayload(mixed $payload): void
    {
        if (! $payload instanceof UpdateInputObject) {
            throw new \Exception('payload must be a instance of UpdateInputObject');
        }

        $this->payload = $payload;
    }
}
