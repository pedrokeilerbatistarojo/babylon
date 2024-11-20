<?php

namespace App\Terminals\Application\Usecases;

use App\Shared\Application\Usecases\TraitHandleShowPayload;
use App\Shared\Contracts\UsecaseInterface;
use App\Shared\Domain\Exceptions\ValidationException;
use App\Terminals\Domain\Models\Terminal;
use App\Terminals\Domain\Resources\TerminalResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShowTerminalUsecase implements UsecaseInterface
{
    use TraitHandleShowPayload;

    /**
     * @throws ValidationException
     */
    public function execute(): TerminalResource
    {

        $id = $this->payload->id;
        $terminal = Terminal::where('id', '=', $id) //Todo add with
            ->first();

        if (! $terminal) {
            throw (new ModelNotFoundException)->setModel(
                'Terminal', [$id]
            );
        }

        return new TerminalResource($terminal);
    }
}
