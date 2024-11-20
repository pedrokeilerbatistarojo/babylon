<?php

namespace App\Terminals\Application\Usecases;

use App\Business\Domain\Models\Business;
use App\Shared\Application\Usecases\TraitHandleUpdatePayload;
use App\Shared\Contracts\UsecaseInterface;
use App\Shared\Domain\Enums\ChannelsEnum;
use App\Shared\Domain\Exceptions\ValidationException;
use App\Shared\Infrastructure\Jobs\NotifyViewJob;
use App\Terminals\Domain\Models\Terminal;
use App\Terminals\Domain\Models\TerminalStatus;
use App\Terminals\Domain\Resources\TerminalResource;
use Illuminate\Support\Facades\Validator;

class UpdateTerminalUsecase implements UsecaseInterface
{
    use TraitHandleUpdatePayload;

    private bool $limit_update = false;

    /**
     * @throws ValidationException
     */
    public function execute(): TerminalResource
    {

        $id = $this->payload->id;
        $terminal = Terminal::findOrfail($id);
        $input = $this->payload->data;
        $validator_conf = [
            'model' => 'required|string|max:255',
            'alias' => 'required|string|max:255',
            'descriptor' => 'required|string|max:255',
            //'company_id' => 'int|exists:companies,id',
            'business_id' => 'int|exists:businesses,id',
            'status_id' => 'int|exists:terminal_statuses,id',
        ];

        if ($this->limit_update) {
            $validator_conf = [
                'business_id' => 'int|exists:businesses,id',
            ];
        }

        //Todo move to custom class
        $validator = Validator::make($input, $validator_conf);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            throw new ValidationException($errors);
        }

        $business_id = $input['business_id'];
        $business = Business::withoutEagerLoads()->where('id', '=', $business_id)->first();
        $company_id = $business->company_id;

        if ($this->limit_update) {
            $input = [
                'business_id' => $business_id,
            ];
        }
        $input['company_id'] = $company_id;
        $agent_id = $business?->agent_id;

        if ($agent_id) {
            $input['agent_id'] = $agent_id;
        } else {
            unset($input['agent_id']);
        }

        $terminal->availability = TerminalStatus::STATUS_ACTIVE && ! $terminal->business_id;
        $terminal->update($input);
        $terminal->fresh();

        NotifyViewJob::dispatch(ChannelsEnum::UPDATE_TERMINALS);

        return new TerminalResource($terminal);
    }

    public function setLimitUpdate(bool $limit_update): void
    {
        $this->limit_update = $limit_update;
    }
}
