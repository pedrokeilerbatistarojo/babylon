<?php

namespace App\Terminals\Infrastructure\Controllers;

use App\Shared\Domain\Dtos\UpdateInputObject;
use App\Shared\Infrastructure\Controllers\BaseController;
use App\Terminals\Application\Usecases\UpdateTerminalStatusUsecase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpdateTerminalStatusController extends BaseController
{
    public function __construct(UpdateTerminalStatusUsecase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @throws \Exception
     */
    public function __invoke(Request $request, int $id, int $status): JsonResponse
    {

        $payload = new UpdateInputObject;
        $payload->id = $id;
        $payload->data = $request->all();
        $payload->data['status_id'] = $status;
        $this->useCase->setPayload($payload);

        return $this->handleResponse($request, 'Terminal update successfully.');
    }
}
