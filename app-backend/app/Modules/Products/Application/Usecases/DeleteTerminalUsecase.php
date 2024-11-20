<?php

namespace App\Terminals\Application\Usecases;

use App\Shared\Application\Usecases\TraitHandleShowPayload;
use App\Shared\Contracts\UsecaseInterface;
use App\Shared\Domain\Dtos\ResponseObject;
use App\Shared\Domain\Enums\ChannelsEnum;
use App\Shared\Domain\Exceptions\ValidationException;
use App\Shared\Infrastructure\Jobs\NotifyViewJob;
use App\Terminals\Domain\Models\Terminal;

class DeleteTerminalUsecase implements UsecaseInterface
{
    use TraitHandleShowPayload;

    /**
     * @throws ValidationException
     */
    public function execute(): ResponseObject
    {

        $id = $this->payload->id;
        $terminal = Terminal::findOrfail($id);
        $terminal->delete();

        NotifyViewJob::dispatch(ChannelsEnum::UPDATE_TERMINALS);

        return new ResponseObject;
    }
}
