<?php

namespace App\Terminals\Application\Usecases;

use App\Business\Domain\Models\Business;
use App\Shared\Application\Usecases\TraitHandleResponsePayload;
use App\Shared\Contracts\UsecaseInterface;
use App\Shared\Domain\Enums\ChannelsEnum;
use App\Shared\Domain\Exceptions\ValidationException;
use App\Shared\Infrastructure\Jobs\NotifyViewJob;
use App\Terminals\Domain\Models\Terminal;
use App\Terminals\Domain\Resources\TerminalResource;
use Illuminate\Support\Facades\Validator;

class CreateTerminalUsecase implements UsecaseInterface
{
    use TraitHandleResponsePayload;

    /**
     * @throws ValidationException
     */
    public function execute(): TerminalResource
    {

        $input = $this->payload;

        //Todo move to custom class
        $validator = Validator::make($input, [
            'external_id' => 'required|uuid|string|max:255|unique:terminals,external_id',
            //'code' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'alias' => 'required|string|max:255',
            'descriptor' => 'required|string|max:255',
            //'company_id' => 'required|int|exists:companies,id',
            'business_id' => 'required|int|exists:businesses,id',
            'status_id' => 'required|int|exists:terminal_statuses,id',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            throw new ValidationException($errors);
        }

        $terminal = Terminal::create($input);
        //$terminal->code = $input['code'];
        $terminal->external_id = $input['external_id'];

        $business = Business::find($input['business_id']);
        if ($business) {
            $terminal->agent_id = $business->agent_id;
        }

        $terminal->save();

        NotifyViewJob::dispatch(ChannelsEnum::UPDATE_TERMINALS);

        return new TerminalResource($terminal);
    }
}
