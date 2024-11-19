<?php

namespace App\Modules\Shared\Application\Usecases;

use App\Shared\Domain\Dtos\SearchRequest;

trait TraitHandleListPayload
{
    protected ?SearchRequest $payload = null;

    /**
     * @throws \Exception
     */
    public function setPayload(mixed $payload): void
    {
        if (! $payload instanceof SearchRequest) {
            throw new \Exception('payload must be a instance of SearchRequest');
        }

        $this->payload = $payload;
    }
}
