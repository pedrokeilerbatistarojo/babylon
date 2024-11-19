<?php

declare(strict_types=1);

namespace App\Modules\Shared\Domain\Dtos;

class WebSocketResponseObject extends ResponseObject
{
    public string $channel = '';

    public string $sender = '';
}
