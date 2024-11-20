<?php

namespace App\Terminals\Application\Usecases;

use App\Shared\Domain\Dtos\ResponseObject;
use App\Terminals\Infrastructure\Jobs\SyncTerminalsJob;

class SyncTerminalsUsecase
{
    public function __construct() {}

    public function execute(): ResponseObject
    {

        SyncTerminalsJob::dispatch();

        return new ResponseObject;
    }
}
